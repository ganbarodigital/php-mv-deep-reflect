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

/**
 * understand a security scope
 */
class ReflectSecurityScope
{
    /**
     * understand a security scope
     *
     * @param  array $modifiers
     *         a list of modifiers extracted by ReflectNodeModifiers
     * @return string
     *         one of 'public', 'protected', 'private', or ''
     */
    public static function from(array $modifiers) : string
    {
        $searchOrder = [ 'private', 'protected', 'public' ];
        foreach ($searchOrder as $searchItem) {
            if (isset($modifiers[$searchItem])) {
                return $modifiers[$searchItem];
            }
        }

        // if we get there, then there is *no* security scope set
        //
        // we could return 'public' here (which is the default behaviour)
        // but we're not trying to parse *behaviour*, but *explicit*
        // declarations
        //
        // an empty string seems the most appropriate
        return '';
    }
}