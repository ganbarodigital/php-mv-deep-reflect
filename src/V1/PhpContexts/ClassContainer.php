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
 * use this in any context that can contain classes
 */
trait ClassContainer
{
    /**
     * get details about a class, by name
     *
     * @param  string $name
     *         the name of the class to look for
     * @param  callable|null $onFailure
     *         what to do if we don't have any such class
     *         Params are:
     *         - `$name` - the name of the class we cannot find
     * @return ClassContext
     * @throws PhpExceptions\NoSuchClass
     *         - if we don't have a class called `$name`, and
     *         - if `$onFailure` is `null`
     */
    public function getClass($name, callable $onFailure = null)
    {
        // make sure we have a way to fail
        $onFailure = $onFailure ?? function($name) {
            throw new PhpExceptions\NoSuchClass($name);
        };

        // do we have it?
        $retval = $this->children[ClassContext::class][$name] ?? $onFailure($name);

        // all done
        return $retval;
    }

    /**
     * get details about all the classes we have
     *
     * @return ClassContext[]
     */
    public function getClasses()
    {
        return $this->children[ClassContext::class] ?? [];
    }

    /**
     * get a list of all the classes we contain
     *
     * @return string[]
     */
    public function getClassNames()
    {
        $classes = $this->getClasses();
        return array_keys($classes);
    }

    /**
     * do we contain a given class?
     *
     * @param  string $name
     *         which class are you looking for?
     * @return boolean
     */
    public function hasClass($name)
    {
        return isset($this->children[ClassContext::class][$name]);
    }

    /**
     * do we contain any classes at all?
     *
     * @return boolean
     *         `true` if we have at least one class defined
     *         `false` otherwise
     */
    public function hasClasses()
    {
        $classes = $this->getClasses();
        return count($classes) > 0;
    }

    /**
     * do we contain any of the listed classes?
     *
     * @param  array $names
     *         the list of classes to check for
     * @return int
     *         the number of classes in $names that we have
     */
    public function hasClassesCalled(array $names)
    {
        $classes = $this->getClasses();
        return count(array_intersect(array_keys($classes), $names));
    }

}
