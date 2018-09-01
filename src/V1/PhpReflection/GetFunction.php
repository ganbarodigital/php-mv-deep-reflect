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

use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpFunctionContainer;
use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpFunction;
use GanbaroDigital\DeepReflection\V1\PhpExceptions;
use GanbaroDigital\MissingBits\ClassesAndObjects\StatelessClass;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;

/**
 * get details about a class, by name
 */
class GetFunction
{
    // we don't want you making objects from this class, sorry!
    use StatelessClass;

    /**
     * get details about a function, by name
     *
     * @param  string $name
     *         the name of the function to look for
     * @param  PhpFunctionContainer $context
     *         the context to extract from
     * @param  OnFatal|null $onFatal
     *         what to do if we don't have any such function
     *         Params are:
     *         - `$name` - the name of the function we cannot find
     * @return PhpFunction
     * @throws PhpExceptions\NoSuchFunction
     *         - if we don't have a function called `$name`, and
     *         - if `$onFailure` is `null`
     */
    public static function from(string $name, PhpFunctionContainer $context, OnFatal $onFatal = null) : PhpFunction
    {
        // make sure we have a way to fail
        $onFatal = $onFatal ?? function($name) {
            throw new PhpExceptions\NoSuchFunction($name);
        };

        // do we have it?
        $functions = GetAllFunctions::from($context);
        $retval = $functions[$name] ?? $onFatal($name);

        // all done
        return $retval;
    }
}
