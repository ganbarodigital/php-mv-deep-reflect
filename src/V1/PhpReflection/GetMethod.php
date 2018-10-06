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

use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpMethod;
use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpMethodContainer;
use GanbaroDigital\DeepReflection\V1\PhpExceptions;
use GanbaroDigital\MissingBits\ClassesAndObjects\StatelessClass;

/**
 * get details about a method, by name
 */
class GetMethod
{
    // we don't want you making objects from this class, sorry!
    use StatelessClass;

    /**
     * get details about a method, by name
     *
     * @param  string $name
     *         the name of the method to look for
     * @param  PhpMethodContainer $context
     *         the context to extract from
     * @param  callable|null $onFailure
     *         what to do if we don't have any such method
     *         Params are:
     *         - `$name` - the name of the method we cannot find
     * @return PhpMethod
     * @throws PhpExceptions\NoSuchMethod
     *         - if we don't have a method called `$name`, and
     *         - if `$onFailure` is `null`
     */
    public static function from(string $name, PhpMethodContainer $context, callable $onFailure = null) : PhpMethod
    {
        // make sure we have a way to fail
        $onFailure = $onFailure ?? function($context, $name) {
            throw new PhpExceptions\NoSuchMethod(
                $context->getName(),
                $name
            );
        };

        // do we have it?
        $methods = GetAllMethods::from($context);
        $retval = $methods[$name] ?? $onFailure($context, $name);

        // all done
        return $retval;
    }
}
