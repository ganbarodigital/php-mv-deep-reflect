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

namespace GanbaroDigital\DeepReflection\V1\Reflectors\PHP;

use GanbaroDigital\DeepReflection\V1\Contexts;
use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\Scope;

use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\DocBlock\Tags;

/**
 * understand a docblock
 */
class ReflectDocblock
{
    /**
     * understand a docblock
     *
     * @param  string $comment
     *         the docblock that we need to parse
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return DocblockContext
     *         what we learned from the docblock
     */
    public static function from(string $comment, Scope $activeScope) : Contexts\DocblockContext
    {
        // what does Mike's parser make of it?
        //
        // we have our own factory, as we need to override some
        // of it's in-built behaviour
        $dbFactory = Helpers\BuildDocblockParser::now();
        try {
            $db = $dbFactory->create($comment);
        }
        catch (\Exception $e) {
            // parsing failed, and there's nothing we can do about it
            // right now
            return new Contexts\DocblockContext('', '', '', [], [], '', []);
        }

        // what do we have?
        $summ = $db->getSummary();
        $desc = $db->getDescription();

        $tags = $db->getTags();

        // var_dump($tags);

        $params = [];
        $retType = [
            'type' => null,
            'description' => null
        ];
        $type = null;
        $others = [];

        foreach ($tags as $tag) {
            switch(true) {
                case $tag instanceof Tags\Param:
                    $paramName = $tag->getVariableName();
                    $params[$paramName] = [
                        'name' => $paramName,
                        'type' => (string)$tag->getType(),
                        'isVariadic' => $tag->isVariadic(),
                        'description' => $tag->getDescription(),
                    ];
                    break;

                case $tag instanceof Tags\Return_:
                    $retType = [
                        'type' => (string)$tag->getType(),
                        'description' => $tag->getDescription()
                    ];
                    break;

                case $tag instanceof Tags\Var_:
                    $type = (string)$tag->getType();
                    break;

                default:
                    $others[] = [
                        'type' => $tag->getName(),
                        'tag' => $tag
                    ];
            }
        }

        $retval = new Contexts\DocblockContext(
            $comment,
            $summ,
            $desc,
            $params,
            $retType,
            $type,
            $others
        );

        // all done
        return $retval;
    }
}