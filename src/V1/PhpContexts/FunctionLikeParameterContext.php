<?php

/**
 * Copyright (c) 2017-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   DeepReflection/PhpContexts
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\PhpContexts;

use GanbaroDigital\DeepReflection\V1\Context;
use GanbaroDigital\DeepReflection\V1\Exceptions\UnsupportedContext;

/**
 * container for describing a parameter for a function-like context
 */
class FunctionLikeParameterContext implements Context
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
     * add something to our scope
     *
     * @param  Context $context
     *         the context that we want to add
     * @return void
     */
    public function attachChildContext(Context $context)
    {
        switch(true) {
            // do nothing
        }
    }

    /**
     * add a context that we belong to
     *
     * @param  Context $context
     *         our parent's context
     * @return void
     */
    public function attachParentContext(Context $context)
    {
        switch(true) {
            case $context instanceof FunctionLikeContext:
                $this->parentFunction = $context;
                break;

            case $context instanceof SourceFileContext:
                // which file were we defined in?
                $this->definedIn = $context;
                break;
        }
    }

    // ==================================================================
    //
    // GET INFORMATION ABOUT THIS CONTEXT
    //
    // ------------------------------------------------------------------

    /**
     * return the PHP namespace for this context
     *
     * @return string | null
     *         - string is empty if this is part of the global scope
     *         - NULL if there is no namespace context available
     */
    public function getContainingNamespace()
    {
        return $this->namespace;
    }

    /**
     * return the docblock for a context - if there is one!
     *
     * @return DocblockContext|null
     */
    public function getDocblock()
    {
        return null;
    }

    /**
     * return the source file where we were defined
     *
     * @return SourceFileContext
     */
    public function getSourceFile() : SourceFileContext
    {
        return $this->definedIn;
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

    public function getName() : string
    {
        return $this->name;
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
