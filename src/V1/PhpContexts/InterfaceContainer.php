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
 * use this in any context that can contain interfaces
 */
trait InterfaceContainer
{
    /**
     * get details about a interface, by name
     *
     * @param  string $name
     *         the name of the interface to look for
     * @param  callable|null $onFailure
     *         what to do if we don't have any such interface
     *         Params are:
     *         - `$name` - the name of the interface we cannot find
     * @return InterfaceContext
     * @throws PhpExceptions\NoSuchInterface
     *         - if we don't have a interface called `$name`, and
     *         - if `$onFailure` is `null`
     */
    public function getInterface($name, callable $onFailure = null)
    {
        // make sure we have a way to fail
        $onFailure = $onFailure ?? function($name) {
            throw new PhpExceptions\NoSuchInterface($name);
        };

        // do we have it?
        $retval = $this->children[InterfaceContext::class][$name] ?? $onFailure($name);

        // all done
        return $retval;
    }

    /**
     * get details about all the interfaces we have
     *
     * @return InterfaceContext[]
     */
    public function getInterfaces()
    {
        return $this->children[InterfaceContext::class] ?? [];
    }

    /**
     * get a list of all the interfaces we contain
     *
     * @return string[]
     */
    public function getInterfaceNames()
    {
        return array_keys($this->getInterfaces());
    }

    /**
     * do we contain a given interface?
     *
     * @param  string $name
     *         which interface are you looking for?
     * @return boolean
     */
    public function hasInterface($name)
    {
        return isset($this->children[InterfaceContext::class][$name]);
    }

    /**
     * do we contain any interfaces at all?
     *
     * @return boolean
     *         `true` if we have at least one interface defined
     *         `false` otherwise
     */
    public function hasInterfaces()
    {
        $interfaces = $this->getInterfaces();
        return count($interfaces) > 0;
    }

    /**
     * do we contain any of the listed interfaces?
     *
     * @param  array $names
     *         the list of interfaces to check for
     * @return int
     *         the number of interfaces in $names that we have
     */
    public function hasInterfacesCalled(array $names)
    {
        $interfaces = $this->getInterfaces();
        return count(array_intersect(array_keys($interfaces), $names));
    }
}
