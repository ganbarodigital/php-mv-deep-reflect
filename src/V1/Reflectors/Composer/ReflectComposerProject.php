<?php

/**
 * Copyright (c) 2017-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   DeepReflection/Reflectors
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\Reflectors\Composer;

use GanbaroDigital\DeepReflection\V1\Contexts;
use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\Reflectors\PHP\ReflectSourceFile;
use GanbaroDigital\DeepReflection\V1\Reflectors\PHP\ReflectSourceFiles;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement as Statements;

/**
 * what's in the project?
 */
class ReflectComposerProject
{
    /**
     * what's in the project?
     *
     * @param  string $path
     *         the folder containing the composer project
     * @param  Scope  $activeScope
     *         the scope for this PHP application
     * @return Contexts\ComposerProjectContext
     *         what we learned about this project
     */
    public static function from(string $path, Scope $activeScope) : Contexts\ComposerProjectContext
    {
        // what's in the project?
        $projectJson = Helpers\LoadJsonFile::from($path, 'composer.json');
        $retval = new Contexts\ComposerProjectContext(
            $projectJson->name,
            $path
        );

        // our scope has changed!
        $activeScope = $activeScope->withComposerComponent($retval);

        // what will it try and autoload?
        $autoloadBits = ReflectComposerAutoload::from($projectJson->autoload, $activeScope);
        foreach ($autoloadBits as $autoloadBit) {
            Helpers\AttachToParents::using($autoloadBit, $activeScope);
        }

        // lets get all those autoload parts examined
        foreach ($retval->getAutoloadPsr0() as $namespace => $psr0Contexts) {
            foreach ($psr0Contexts as $psr0Context) {
                $searchPath = Helpers\BuildFilePath::using($path, $psr0Context->getAutoloadPath());
                $sourceFileCtxs = ReflectSourceFiles::from($searchPath, ['php'], $activeScope);
                foreach ($sourceFileCtxs as $sourceFileCtx) {
                    Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
                }
            }
        }
        foreach ($retval->getAutoloadPsr4() as $namespace => $psr4Contexts) {
            foreach ($psr4Contexts as $psr4Context) {
                $searchPath = Helpers\BuildFilePath::using($path, $psr4Context->getAutoloadPath());
                $sourceFileCtxs = ReflectSourceFiles::from($searchPath, ['php'], $activeScope);
                foreach ($sourceFileCtxs as $sourceFileCtx) {
                    Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
                }
            }
        }
        foreach ($retval->getAutoloadFiles() as $filesContext) {
            $filename = Helpers\BuildFilePath::using($path, $filesContext->getAutoloadPath());
            $sourceFileCtx = ReflectSourceFile::from($filename, $activeScope);
            Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
        }
        foreach ($retval->getAutoloadClassmaps() as $classmapsContext) {
            $vendorPath = Helpers\BuildFilePath::using($path, $classmapsContext->getAutoloadPath());
            $sourceFileCtxs = ReflectSourceFiles::from($vendorPath, ['php', 'inc'], $activeScope);
            foreach ($sourceFileCtxs as $sourceFileCtx) {
                Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
            }
        }

        // what's in the vendor folder?
        $installedJson = Helpers\LoadJsonFile::from($path, 'vendor', 'composer', 'installed.json');
        foreach ($installedJson as $installedComponent) {
            $installedCtx = ReflectInstalledComposerComponent::from($path, $installedComponent, $activeScope);
            Helpers\AttachToParents::using($installedCtx, $activeScope);
        }

        // all done
        return $retval;
    }
}