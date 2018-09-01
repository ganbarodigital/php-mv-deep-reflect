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
 * use this in any context that can contain namespaces
 */
trait NamespaceContainer
{
    /**
     * get details about a namespace, by name
     *
     * @param  string $name
     *         the name of the namespace to look for
     * @param  callable|null $onFailure
     *         what to do if we don't have any such namespace
     *         Params are:
     *         - `$name` - the name of the namespace we cannot find
     * @return NamespaceContext
     * @throws PhpExceptions\NoSuchNamespace
     *         - if we don't have a namespace called `$name`, and
     *         - if `$onFailure` is `null`
     */
    public function getNamespace($name, callable $onFailure = null)
    {
        // make sure we have a way to fail
        $onFailure = $onFailure ?? function($name) {
            throw new PhpExceptions\NoSuchNamespace($name);
        };

        // do we have it?
        $retval = $this->children[NamespaceContext::class][$name] ?? $onFailure($name);

        // all done
        return $retval;
    }

    /**
     * get details about all the namespaces we have
     *
     * @return NamespaceContext[]
     */
    public function getNamespaces()
    {
        return $this->children[NamespaceContext::class] ?? [];
    }

    /**
     * get a list of all the namespaces we contain
     *
     * @return string[]
     */
    public function getNamespaceNames()
    {
        return array_keys($this->getNamespaces());
    }

    /**
     * do we contain a given namespace?
     *
     * @param  string $name
     *         which namespace are you looking for?
     * @return boolean
     */
    public function hasNamespace($name)
    {
        return isset($this->children[NamespaceContext::class][$name]);
    }

    /**
     * do we contain any namespaces at all?
     *
     * @return boolean
     *         `true` if we have at least one namespace defined
     *         `false` otherwise
     */
    public function hasNamespaces()
    {
        $namespaces = $this->getNamespaces();
        return count($namespaces) > 0;
    }

    /**
     * do we contain any of the listed namespaces?
     *
     * @param  array $names
     *         the list of namespaces to check for
     * @return int
     *         the number of namespaces in $names that we have
     */
    public function hasNamespacesCalled(array $names)
    {
        $namespaces = $this->getNamespaces();
        return count(array_intersect(array_keys($namespaces), $names));
    }

}
