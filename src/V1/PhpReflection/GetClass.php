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

use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpClassContainer;
use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpClass;
use GanbaroDigital\DeepReflection\V1\PhpExceptions;

/**
 * get details about a class, by name
 */
class GetClass
{
    /**
     * get details about a class, by name
     *
     * @param  PhpClassContainer $context
     *         the context to extract from
     * @param  string $name
     *         the name of the class to look for
     * @param  callable|null $onFailure
     *         what to do if we don't have any such class
     *         Params are:
     *         - `$name` - the name of the class we cannot find
     * @return PhpClass
     * @throws PhpExceptions\NoSuchClass
     *         - if we don't have a class called `$name`, and
     *         - if `$onFailure` is `null`
     */
    public static function from(PhpClassContainer $context, string $name, callable $onFailure = null) : PhpClass
    {
        // make sure we have a way to fail
        $onFailure = $onFailure ?? function($name) {
            throw new PhpExceptions\NoSuchClass($name);
        };

        // do we have it?
        $classes = GetAllClasses::from($context);
        $retval = $classes[$name] ?? $onFailure($name);

        // all done
        return $retval;
    }
}
