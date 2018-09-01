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

/**
 * container for describing a parameter for a function-like context
 */
class PhpFunctionLikeParameter extends PhpSourceCode
{
    /**
     * the parameter's type-hint, if available
     *
     * @var string | null
     */
    protected $typeHint;

    /**
     * is this parameter being passed by reference?
     *
     * @var bool
     */
    protected $passByReference;

    /**
     * is this parameter variadic?
     *
     * @var bool
     */
    protected $isVariadic;

    /**
     * what is the name of this parameter?
     *
     * @var string
     */
    protected $name;

    /**
     * does this parameter have a default value?
     *
     * @var bool
     */
    protected $hasDefaultValue;

    /**
     * what is the default value of this parameter,
     * if $hasDefaultValue is true?
     *
     * @var string | null
     */
    protected $defaultValue;

    /**
     * what is our parent function or method?
     *
     * @var FunctionLikeContext
     */
    protected $parentFunction;

    /**
     * which file are we defined in?
     *
     * @var SourceFileContext
     */
    protected $definedIn;

    /**
     * our constructor
     *
     * @param string|null $typeHint
     *        the type-hint for this parameter
     * @param bool $passByReference
     *        is this parameter being passed by reference?
     * @param bool $isVariadic
     *        is this parameter variadic?
     * @param string $name
     *        what is the name of this parameter?
     * @param bool $hasDefaultValue
     *        does parameter have a default value?
     * @param string|null $defaultValue
     *        what is the default value (if $hasDefaultValue is true)
     */
    public function __construct(string $typeHint = null, bool $passByReference, bool $isVariadic, string $name, bool $hasDefaultValue, string $defaultValue = null)
    {
        $this->typeHint = $typeHint;
        $this->passByReference = $passByReference;
        $this->isVariadic = $isVariadic;
        $this->name = $name;
        $this->hasDefaultValue = $hasDefaultValue;
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
        return 'function/method parameter';
    }


    public function hasTypeHint() : bool
    {
        if ($this->typeHint !== null) {
            return true;
        }

        return false;
    }

    public function isPassByReference() : bool
    {
        return $this->passByReference;
    }

    public function isVariadic() : bool
    {
        return $this->isVariadic;
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
