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
 * @package   DeepReflection/ComposerReflectors
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
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