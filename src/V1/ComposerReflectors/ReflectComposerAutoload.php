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
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement as Statements;

/**
 * understand the autoloaded details
 */
class ReflectComposerAutoload
{
    public static function from($autoloadSection, Scope $activeScope)
    {
        $retval = [];

        if (isset($autoloadSection->{'psr-0'})) {
            $retval = array_append_values($retval, self::analysePsr($autoloadSection->{'psr-0'}, ComposerContexts\AutoloadPsr0Context::class));
        }
        if (isset($autoloadSection->{'psr-4'})) {
            $retval = array_append_values($retval, self::analysePsr($autoloadSection->{'psr-4'}, ComposerContexts\AutoloadPsr4Context::class));
        }
        if (isset($autoloadSection->files)) {
            $retval = array_append_values($retval, self::analyseFiles($autoloadSection->files, ComposerContexts\AutoloadFileContext::class));
        }
        if (isset($autoloadSection->classmap)) {
            $retval = array_append_values($retval, self::analyseClassmap($autoloadSection->classmap, ComposerContexts\AutoloadClassmapContext::class));
        }

        // all done
        return $retval;
    }

    protected static function analysePsr($psrSection, $contextClassname)
    {
        $retval = [];

        foreach ($psrSection as $namespace => $paths) {
            if (!is_array($paths)) {
                $paths = [ $paths ];
            }
            foreach ($paths as $path) {
                $retval[] = new $contextClassname($namespace, $path);
            }
        }

        return $retval;
    }

    protected static function analyseFiles($filesSection)
    {
        $retval = [];

        foreach ($filesSection as $filename) {
            $retval[] = new ComposerContexts\AutoloadFileContext('', $filename);
        }

        return $retval;
    }

    protected static function analyseClassmap($classmapSection)
    {
        $retval = [];

        foreach ($classmapSection as $path) {
            $retval[] = new ComposerContexts\AutoloadClassmapContext('', $path);
        }

        return $retval;
    }
}