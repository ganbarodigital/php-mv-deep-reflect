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
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\Reflection;

use GanbaroDigital\DeepReflection\V1\Contexts;

/**
 * PHP's ReflectionParameter, using our Deep Reflection data
 */
class ReflectionParameter
{
    /**
     * the information available about this class
     * @var Contexts\ClassContext
     */
    private $context;

    private function __construct(Contexts\ClassContext $context)
    {
        $this->context = $context;
    }

    // ==================================================================
    //
    // PHP.net API
    //
    // ------------------------------------------------------------------

    /**
     * can you pass `null` into this parameter?
     *
     * @return boolean
     */
    public function allowsNull()
    {

    }

    /**
     * can you pass a value (ie a number or string defined in your code)
     * into this parameter?
     *
     * @return boolean
     */
    public function canBePassedByValue()
    {

    }

    public function export()
    {
        // DO NOT SUPPORT?
    }

    /**
     * which function is this a parameter for?
     *
     * @return ReflectionFunctionLike
     */
    public function getDeclaringFunction()
    {

    }

    /**
     * what is the default value for this parameter
     *
     * @return mixed
     * @throws ParameterIsNotOptional if this parameter is not optional
     */
    public function getDefaultValue()
    {

    }

    /**
     * what is the default value for this parameter? before PHP expands it?
     *
     * @return string|null
     */
    public function getDefaultValueConstantName()
    {

    }

    /**
     * what is the name of this parameter?
     *
     * @return string
     */
    public function getName()
    {

    }

    /**
     * where does this parameter come in the list of parameters for its
     * function/method?
     *
     * @return int
     */
    public function getPosition()
    {

    }

    /**
     * does this parameter have a default value?
     *
     * @return boolean
     */
    public function isDefaultValueAvailable()
    {

    }

    /**
     * does this parameter have a default value, and is that default value
     * a PHP constant of some kind?
     *
     * @return boolean
     *         - `true` if the default value is a PHP constant
     *         - `false` if the default value isn't a PHP constant
     *         - `false` if there is no default value
     */
    public function isDefaultValueConstant()
    {

    }

    /**
     * is this parameter optional?
     *
     * @return boolean
     */
    public function isOptional()
    {

    }

    /**
     * is this parameter passed by reference?
     *
     * @return boolean
     */
    public function isPassedByReference()
    {

    }

    /**
     * is this parameter variadic?
     *
     * @return boolean
     */
    public function isVariadic()
    {

    }

    /**
     * return a representation of this parameter
     *
     * @return string
     */
    public function __toString()
    {

    }

    // ==================================================================
    //
    // DeepReflection API
    //
    // ------------------------------------------------------------------

    /**
     * get the docblock for a class
     *
     * @return ReflectionDocBlock|null
     */
    public function getDocblock()
    {

    }

    /**
     * which composer project defines this method?
     *
     * @return ReflectionComposerPackage|null
     */
    public function getComposerProject()
    {

    }

    /**
     * which composer project defines this method?
     *
     * @return string|false
     */
    public function getComposerProjectName()
    {

    }

    /**
     * what is the type-hint for this parameter?
     *
     * - uses the one defined in the PHP code (if present)
     * - then looks for one defined in the docblock (if present)
     *
     * @return ReflectionType|null
     */
    public function getTypeHint()
    {

    }

    /**
     * does this parameter have a type-hint?
     *
     * @return boolean
     *         - `true` if there's a type-hint defined in the PHP code
     *         - `true` if there's a type-hint defined in the docblock
     *         - `false` otherwise
     */
    public function hasTypeHint()
    {

    }

    /**
     * get the type-hint defined in the PHP code (if any)
     *
     * @return ReflectionType|null
     */
    public function getDeclaredType()
    {

    }

    /**
     * does this parameter's type-hint come from the PHP code?
     *
     * @return boolean
     *         - `true` if there's a type-hint defined in the PHP code
     *         - `false` if there isn't one in the PHP code
     */
    public function hasDeclaredType()
    {

    }

    /**
     * get the type-hint defined in the function|method's docblock (if any)
     *
     * @return ReflectionType[]
     */
    public function getDocblockTypeHint()
    {

    }

    /**
     * does this parameter have a type-hint defined in the function|method's
     * docblock?
     *
     * @return boolean
     *         - `true` if there's a type-hint defined in the docblock
     *         - `false` otherwise
     */
    public function hasDocblockTypeHint()
    {

    }
}