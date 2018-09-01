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

use GanbaroDigital\DeepReflection\V1\Context;
use GanbaroDigital\DeepReflection\V1\Exceptions\UnsupportedContext;

/**
 * container for describing a property on a class-like context
 */
class PhpProperty extends PhpSourceCode
  implements PhpDocblockContainer
{
    /**
     * what is the name of this property?
     *
     * @var string
     */
    protected $name;

    /**
     * what is our default value?
     *
     * @var string|null
     */
    protected $defaultValue;

    /**
     * are we a static property?
     * @var bool
     */
    protected $isStatic;

    /**
     * are we public, private, protected, or <empty string>?
     * @var string
     */
    protected $securityScope;

    /**
     * which file are we defined in?
     *
     * @var SourceFileContext
     */
    protected $definedIn;

    /**
     * what does our docblock say about our params (if anything)?
     *
     * @var array
     */
    protected $docBlockParams = [];

    /**
     * what does our docblock say about our return type (if anything)?
     *
     * @var array
     */
    protected $docBlockReturnType = [];

    public function __construct(string $securityScope, bool $isStatic, string $name, string $defaultValue = null)
    {
        $this->securityScope = $securityScope;
        $this->isStatic = $isStatic;
        $this->name = $name;
        $this->defaultValue = $defaultValue;
    }

    /**
     * what is the name of the context we represent?
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
        return 'class property';
    }


    public function hasTypeHint() : bool
    {
        if ($this->typeHint !== null) {
            return true;
        }

        return false;
    }

    public function hasDefaultValue() : bool
    {
        return $this->hasDefaultValue;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
}
