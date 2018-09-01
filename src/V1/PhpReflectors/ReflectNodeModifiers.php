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

use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node;

/**
 * extract the list of modifiers for a class or function or similar
 */
class ReflectNodeModifiers
{
    /**
     * extract the list of modifiers for a class or function or similar
     *
     * @param  Node $node
     *         the AST where the modifiers are
     * @param  array $modifierTokens
     *         a list of the modifier tokens to understand
     * @return array
     *         a list of modifiers found
     */
    public static function from(Node $node, array $modifiers) : array
    {
        // our return value
        $retval = [];

        // let's find out what kind of modifiers it has
        foreach ($modifiers as $modifierToken) {
            $modifier = Helpers\GetTokenText::from($node, $modifierToken);
            $retval[$modifier] = $modifier;
        }

        // all done
        return $retval;
    }
}