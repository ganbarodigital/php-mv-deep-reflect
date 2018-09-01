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

namespace GanbaroDigital\DeepReflection\V1\Helpers;

use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Contexts;
use GanbaroDigital\DeepReflection\V1\Reflectors;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node;

/**
 * separate out different comments in the same piece of text
 */
class SeparateComments
{
    /**
     * separate out different comments in the same piece of text
     *
     * if we can't find any comments, we'll return the original $text
     * back to you
     *
     * @param  string $text
     *         the text that is believed to contain comments
     * @return array
     *         a list of extracted comments
     */
    public static function using(string $text) : array
    {
        // based on the regex by asika32764
        // https://gist.github.com/asika32764/9268066
        $matches = [];
        $matched = preg_match_all(
            "/(\/\*(?:[^*]|\n|(?:\*(?:[^\/]|\n)))*\*\/\\s+)|((?:\/\/.*\n\\s)+)\s/",
            $text,
            $matches
        );

        // did we get anything?
        if (!$matched) {
            // no, so send the original text back
            return [$text];
        }

        // yes, we did :)
        //
        // send back the comments that we have separated out
        return $matches[0];
    }
}