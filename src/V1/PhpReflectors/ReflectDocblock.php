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

namespace GanbaroDigital\DeepReflection\V1\PhpReflectors;

use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\PhpContexts;
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
     * @return PhpContexts\PhpDocblock
     *         what we learned from the docblock
     */
    public static function from(string $comment, Scope $activeScope) : PhpContexts\PhpDocblock
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
            return new PhpContexts\PhpDocblock('', '', '', [], [], '', []);
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

        $retval = new PhpContexts\PhpDocblock(
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