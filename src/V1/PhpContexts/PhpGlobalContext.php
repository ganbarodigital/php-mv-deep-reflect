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

use GanbaroDigital\DeepReflection\V1\PhpReflection\GetNamespace;
use GanbaroDigital\DeepReflection\V1\PhpScopes\PhpScope;

/**
 * container for everything in the global scope
 */
class PhpGlobalContext extends PhpNamespace
  implements PhpNamespaceContainer
{
    /**
     * our constructor
     */
    public function __construct()
    {
        // we are the outermost part of the PHP runtime env
        //
        // we always start with a fresh scope
        $activeScope = new PhpScope($this);

        parent::__construct($activeScope, '\\');

        // this is how we make sure that we appear as a namespace too
        // we are the GLOBAL namespace :)
        // $this->attachChildContextType('\\', NamespaceContext::class, $this);
    }

    /**
     * what is the name of the context we represent?
     *
     * @return string
     */
    public function getName()
    {
        return '\\';
    }

    /**
     * what kind of context are we?
     *
     * this should be human-readable, suitable for putting in error
     * messages as so on
     *
     * @return string
     */
    public function getContextType()
    {
        return PhpContextTypes::GLOBAL_CONTEXT;
    }

    // ==================================================================
    //
    // Deep Reflection API
    //
    // ------------------------------------------------------------------

    /**
     * create a context for a given namespace
     *
     * if we already have a context for `$namespace`, we return the
     * existing context (so that you can add to it)
     *
     * @param  PhpScope $activeScope
     *         the active scope at the time we discovered this namespace
     * @param  string $namespace
     *         the namespace you want to add to our global context
     * @return NamespaceContext
     */
    public function createNamespace(PhpScope $activeScope, string $namespace)
    {
        // if this namespace doesn't exist, we want to create it
        $onFailure = function ($namespace) use ($activeScope) {
            $retval = new PhpNamespace($activeScope, $namespace);

            // remember to attach it, so that future calls to
            // `createNamespace()` or `getNamespace()` will find it
            $this->attachChildContext(
                $namespace, $retval
            );

            return $retval;
        };

        // get it, and create it if it doesn't exist
        return GetNamespace::from($this, $namespace, $onFailure);
    }

    /**
     * use this to get this namespace with '\' on the end
     * suitable for using as a prefix in your code
     *
     * @return string
     */
    public function getNameAsPrefix()
    {
        return '';
    }

}
