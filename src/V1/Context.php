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

use GanbaroDigital\DeepReflection\V1\Context;
use GanbaroDigital\DeepReflection\V1\Scope;

/**
 * base type for all data about discovered facts
 *
 * extend this to add helper methods for the specific context
 * that you are capturing
 */
abstract class Context
{
    /**
     * our children
     * @var array
     */
    protected $children = [];

    /**
     * our constructor
     *
     * @param Scope $scope
     *        the scope at the time this context was created
     */
    public function __construct(Scope $scope)
    {
        $this->scope = $scope;
    }

    /**
     * add something to our discovered facts
     *
     * @param  string|int|null $name
     *         what do we call this context (what is its name as far as our
     *         context is concerned)?
     * @param  Context $context
     *         the context that we want to add
     * @return void
     */
    public function attachChildContext($name, Context $context)
    {
        $this->attachChildContextType($name, get_class($context), $context);
    }

    /**
     * add something to our discovered facts
     *
     * @param  string|int|null $name
     *         what do we call this context (what is its name as far as our
     *         context is concerned)?
     * @param  string $contextType
     *         what kind of context is this?
     * @param  Context $context
     *         the context that we want to add
     * @return void
     */
    public function attachChildContextType($name, string $contextType, Context $context)
    {
        // force a type-conversion if we have a simulated type-alias
        $name = is_object($name) ? (string)$name : $name;
        if ($name == 'PhpClassName') {
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            exit(1);
        }

        $this->children[$contextType][$name] = $context;
    }

    /**
     * add one or more somethings to our discovered facts
     *
     * @param  Context[] $contexts
     *         the context that we want to add
     * @return void
     */
    public function attachChildContexts(array $contexts)
    {
        foreach ($contexts as $name => $context) {
            $this->children[get_class($context)][$name] = $context;
        }
    }

    /**
     * get all of our child contexts
     *
     * use this only when you can't get what you need from any helper
     * methods that are available
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * get all child contexts of a given type
     *
     * @param  string $type
     *         what kind of children do you want?
     *         this is normally a class name
     * @return array
     */
    public function getChildrenByType(string $type)
    {
        return $this->children[$type] ?? [];
    }

    /**
     * get the current scope to analyse
     *
     * @return Scope
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * what is the name of the context we represent?
     *
     * this might be any of:
     *
     * - namespace name
     * - class name
     * - file name
     *
     * and so on
     *
     * @return string|int
     */
    abstract public function getName();

    /**
     * what is the name of this context, in the context that it is being
     * used?
     *
     * @return string
     */
    abstract public function getInContextName();

    /**
     * what kind of context are we?
     *
     * this should be human-readable, suitable for putting in error
     * messages as so on
     *
     * @return string
     */
    abstract public function getContextType();
}
