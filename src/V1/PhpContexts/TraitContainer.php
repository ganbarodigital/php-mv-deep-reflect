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
 * use this in any context that can contain traits
 */
trait TraitContainer
{
    /**
     * get details about a trait, by name
     *
     * @param  string $name
     *         the name of the trait to look for
     * @param  callable|null $onFailure
     *         what to do if we don't have any such trait
     *         Params are:
     *         - `$name` - the name of the trait we cannot find
     * @return TraitContext
     * @throws PhpExceptions\NoSuchTrait
     *         - if we don't have a trait called `$name`, and
     *         - if `$onFailure` is `null`
     */
    public function getTrait($name, callable $onFailure = null)
    {
        // make sure we have a way to fail
        $onFailure = $onFailure ?? function($name) {
            throw new PhpExceptions\NoSuchTrait($name);
        };

        // do we have it?
        $retval = $this->children[TraitContext::class][$name] ?? $onFailure($name);

        // all done
        return $retval;
    }

    /**
     * get details about all the traits we have
     *
     * @return TraitContext[]
     */
    public function getTraits()
    {
        return $this->children[TraitContext::class] ?? [];
    }

    /**
     * get a list of all the traits we contain
     *
     * @return string[]
     */
    public function getTraitNames()
    {
        return array_keys($this->getTraits());
    }

    /**
     * do we contain a given trait?
     *
     * @param  string $name
     *         which trait are you looking for?
     * @return boolean
     */
    public function hasTrait($name)
    {
        return isset($this->children[TraitContext::class][$name]);
    }

    /**
     * do we contain any traits at all?
     *
     * @return boolean
     *         `true` if we have at least one trait defined
     *         `false` otherwise
     */
    public function hasTraits()
    {
        $traits = $this->getTraits();
        return count($traits) > 0;
    }

    /**
     * do we contain any of the listed traits?
     *
     * @param  array $names
     *         the list of traits to check for
     * @return int
     *         the number of traits in $names that we have
     */
    public function hasTraitsCalled(array $names)
    {
        $traits = $this->getTraits();
        return count(array_intersect(array_keys($traits), $names));
    }
}