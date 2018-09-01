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

namespace GanbaroDigital\DeepReflection\V1\PhpReflection;

use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpNamespaceContainer;
use GanbaroDigital\MissingBits\ClassesAndObjects\StatelessClass;

/**
 * how many named namespaces does the context have?
 */
class HasNamespacesCalled
{
    // we don't want you making objects from this class, sorry!
    use StatelessClass;

    /**
     * how many named namespaces does the context have?
     *
     * @param  array $names
     *         the list of namespaces to check for
     * @param  PhpNamespaceContainer $context
     *         the context to examine
     * @return int
     *         the number of namespaces in $names that the context has
     */
    public static function check(array $names, PhpNamespaceContainer $context) : int
    {
        $namespaces = GetAllNamespaces::from($context);
        return count(array_intersect(array_keys($namespaces), $names));
    }
}