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

namespace GanbaroDigital\DeepReflection\V1\PhpContexts;

use GanbaroDigital\DeepReflection\V1\PhpExceptions;
use GanbaroDigital\DeepReflection\V1\PhpHelpers;

/**
 * use this in any context that can contain functions
 */
trait FunctionContainer
{
    /**
     * get details about a function, by name
     *
     * @param  string $name
     *         the name of the function to look for
     * @param  callable|null $onFailure
     *         what to do if we don't have any such function
     *         Params are:
     *         - `$name` - the name of the function we cannot find
     * @return FunctionContext
     * @throws NoSuchFunction
     *         - if we don't have a function called `$name`, and
     *         - if `$onFailure` is `null`
     */
    public function getFunction($name, callable $onFailure = null)
    {
        // make sure we have a way to fail
        $onFailure = $onFailure ?? function($name) {
            throw new PhpExceptions\NoSuchFunction($name);
        };

        // do we have it?
        $retval = $this->children[FunctionContext::class][$name] ?? $onFailure($name);

        // all done
        return $retval;
    }

    /**
     * get details about all the functions we have
     *
     * @return FunctionContext[]
     */
    public function getFunctions()
    {
        return $this->children[FunctionContext::class] ?? [];
    }

    /**
     * get a list of all the classes we contain
     *
     * @return string[]
     */
    public function getFunctionNames()
    {
        return array_keys($this->getFunctions());
    }

    /**
     * do we contain a given function?
     *
     * @param  string $name
     *         which function are you looking for?
     * @return boolean
     */
    public function hasFunction($name)
    {
        // what is the name we are looking for?
        return isset($this->children[FunctionContext::class][$name]);
    }

    /**
     * do we contain any functions at all?
     *
     * @return boolean
     *         `true` if we have at least one function defined
     *         `false` otherwise
     */
    public function hasFunctions()
    {
        $functions = $this->getFunctions();
        return count($functions) > 0;
    }

    /**
     * do we contain any of the listed functions?
     *
     * @param  array $names
     *         the list of functions to check for
     * @return int
     *         the number of functions in $names that we have
     */
    public function hasFunctionsCalled(array $names)
    {
        $functions = $this->getFunctions();
        return count(array_intersect(array_keys($functions), $names));
    }
}
