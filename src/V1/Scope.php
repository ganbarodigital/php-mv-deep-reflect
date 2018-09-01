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

namespace GanbaroDigital\DeepReflection\V1;

/**
 * base type for all code / project scopes
 */
class Scope
{
    /**
     * all the contexts that together make up the current scope
     * @var Context[]
     */
    protected $contexts = [];

    /**
     * add a new context to the current scope
     *
     * NOTE: this returns a new scope
     *
     * @param  Context $context
     *         the context to add
     * @return Scope
     */
    public function with(Context $context)
    {
        $retval = clone $this;
        $retval->contexts = $this->contexts;
        $retval->contexts[get_class($context)] = $context;

        return $retval;
    }

    /**
     * get a context (if we have it)
     *
     * @param  string $contextClassname
     *         class name of the context to look for
     * @return Context|null
     */
    protected function getContext($contextClassname)
    {
        return $this->contexts[$contextClassname] ?? null;
    }

    /**
     * return the name of a context, if we have it
     *
     * @param  string $contextClassname
     *         class name of the context to look for
     * @return string|null
     */
    protected function getContextName($contextClassname)
    {
        return $this->contexts[$contextClassname] ? $this->contexts[$contextClassname]->getName() : null;
    }
}
