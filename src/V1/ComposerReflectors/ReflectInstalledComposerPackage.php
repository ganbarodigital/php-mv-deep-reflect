<?php

/**
 * Copyright (c) 2017-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * If you wish to use this program in proprietary software, you can purchase
 * a closed-source license. Contact licensing@ganbarodigital.com for details.
 *
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   https://www.gnu.org/licenses/agpl.html  GNU Affero GPL v3
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\ComposerReflectors;

use GanbaroDigital\DeepReflection\V1\ComposerContexts;
use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\PhpReflectors;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement as Statements;

/**
 * understand an entry from composer's installed.json file
 */
class ReflectInstalledComposerPackage
{
    public static function from($projectRootPath, $installedDetails, Scope $activeScope)
    {
        $retval = new ComposerContexts\InstalledComposerPackageContext(
            $installedDetails->name,
            $installedDetails->version
        );
        $activeScope = $activeScope->withComposerPackage($retval);

        $autoloadBits = ReflectComposerAutoload::from($installedDetails->autoload ?? [], $activeScope);
        foreach ($autoloadBits as $autoloadBit) {
            Helpers\AttachToParents::using($autoloadBit, $activeScope);
        }

        // lets get all those autoload parts examined
        foreach ($retval->getAutoloadPsr0() as $namespace => $psr0Contexts) {
            foreach ($psr0Contexts as $psr0Context) {
                $searchPath = Helpers\BuildFilePath::using($projectRootPath, 'vendor', $retval->getComponentName(), $psr0Context->getAutoloadPath());
                $sourceFileCtxs = PhpReflectors\ReflectSourceFiles::from($searchPath, ['php'], $activeScope);
                foreach ($sourceFileCtxs as $sourceFileCtx) {
                    Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
                }
            }
        }
        foreach ($retval->getAutoloadPsr4() as $namespace => $psr4Contexts) {
            foreach ($psr4Contexts as $psr4Context) {
                $searchPath = Helpers\BuildFilePath::using($projectRootPath, 'vendor', $retval->getComponentName(), $psr4Context->getAutoloadPath());
                $sourceFileCtxs = PhpReflectors\ReflectSourceFiles::from($searchPath, ['php'], $activeScope);
                foreach ($sourceFileCtxs as $sourceFileCtx) {
                    Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
                }
            }
        }
        foreach ($retval->getAutoloadFiles() as $filesContext) {
            $filename = Helpers\BuildFilePath::using($projectRootPath, 'vendor', $retval->getComponentName(), $filesContext->getAutoloadPath());
            $sourceFileCtx = PhpReflectors\ReflectSourceFile::from($filename, $activeScope);
            Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
        }
        foreach ($retval->getAutoloadClassmaps() as $classmapsContext) {
            $vendorPath = Helpers\BuildFilePath::using($projectRootPath, 'vendor', $retval->getComponentName(), $classmapsContext->getAutoloadPath());
            $sourceFileCtxs = PhpReflectors\ReflectSourceFiles::from($vendorPath, ['php', 'inc'], $activeScope);
            foreach ($sourceFileCtxs as $sourceFileCtx) {
                Helpers\AttachToParents::using($sourceFileCtx, $activeScope);
            }
        }

        return $retval;
    }
}