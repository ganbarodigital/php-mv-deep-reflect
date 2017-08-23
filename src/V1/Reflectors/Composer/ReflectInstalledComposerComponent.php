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
 * understand an entry from composer's installed.json file
 */
class ReflectInstalledComposerComponent
{
    public static function from($projectRootPath, $installedDetails, Scope $activeScope)
    {
        $retval = new Contexts\InstalledComposerComponentContext(
            $installedDetails->name,
            $installedDetails->version
        );
        $activeScope = $activeScope->withComposerComponent($retval);

        $autoloadBits = ReflectComposerAutoload::from($installedDetails->autoload ?? [], $activeScope);
        foreach ($autoloadBits as $autoloadBit) {
            Helpers\AttachToParents::using($autoloadBit, $activeScope);
        }

        // lets get all those autoload parts examined
        foreach ($retval->getAutoloadPsr0() as $namespace => $psr0Contexts) {
            foreach ($psr0Contexts as $psr0Context) {
                $searchPath = Helpers\BuildFilePath::using($projectRootPath, 'vendor', $retval->getComponentName(), $psr0Context->getAutoloadPath());
                $sourceFileCtxs = ReflectSourceFiles::from($searchPath, ['php'], $activeScope);
                foreach ($sourceFileCtxs as $sourceFileCtx) {
                    Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
                }
            }
        }
        foreach ($retval->getAutoloadPsr4() as $namespace => $psr4Contexts) {
            foreach ($psr4Contexts as $psr4Context) {
                $searchPath = Helpers\BuildFilePath::using($projectRootPath, 'vendor', $retval->getComponentName(), $psr4Context->getAutoloadPath());
                $sourceFileCtxs = ReflectSourceFiles::from($searchPath, ['php'], $activeScope);
                foreach ($sourceFileCtxs as $sourceFileCtx) {
                    Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
                }
            }
        }
        foreach ($retval->getAutoloadFiles() as $filesContext) {
            $filename = Helpers\BuildFilePath::using($projectRootPath, 'vendor', $retval->getComponentName(), $filesContext->getAutoloadPath());
            $sourceFileCtx = ReflectSourceFile::from($filename, $activeScope);
            Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
        }
        foreach ($retval->getAutoloadClassmaps() as $classmapsContext) {
            $vendorPath = Helpers\BuildFilePath::using($projectRootPath, 'vendor', $retval->getComponentName(), $classmapsContext->getAutoloadPath());
            $sourceFileCtxs = ReflectSourceFiles::from($vendorPath, ['php', 'inc'], $activeScope);
            foreach ($sourceFileCtxs as $sourceFileCtx) {
                Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
            }
        }

        return $retval;
    }
}