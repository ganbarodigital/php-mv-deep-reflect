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
 * PHP's ReflectionFunctionAbstract, using our Deep Reflection data
 */
class ReflectionFunctionLike
{
    const IS_STATIC = 1;
    const IS_PUBLIC = 256;
    const IS_PROTECTED = 512;
    const IS_PRIVATE = 1024;
    const IS_ABSTRACT = 2;
    const IS_FINAL = 4;

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
     * get the docblock for this function-like thing
     *
     * @return string
     */
    public function getDocComment()
    {

    }

    /**
     * get the line number where the function-like thing's definition ends
     *
     * @return int|false
     *         - `int` if the line number is known
     *         - `false` otherwise
     */
    public function getEndLine()
    {

    }

    /**
     * which file was this class defined in?
     *
     * @return string|false
     *         - `string` if it was defined in a file
     *         - `false` if it is built-in or in a PHP extension
     */
    public function getFileName()
    {

    }

    /**
     * what is this class called?
     *
     * returns the fully-qualified classname
     *
     * @return string
     */
    public function getName()
    {

    }

    /**
     * what namespace is this class defined in?
     *
     * @return string
     *         - an empty string if the class is not in a namespace
     */
    public function getNamespaceName()
    {

    }

    /**
     * how many parameters does this function-like thing accept?
     *
     * this includes required and optional parameters
     *
     * @return int
     */
    public function getNumberOfParameters()
    {

    }

    /**
     * how many parameters does this function-like thing require?
     *
     * @return int
     */
    public function getNumberOfRequiredParameters()
    {

    }

    /**
     * get a list of the parameters this function-like thing accepts
     *
     * @return ReflectionParameter[]
     */
    public function getParameters()
    {

    }

    /**
     * what does this function-like thing return?
     *
     * @return ReflectionType|null
     */
    public function getReturnType()
    {

    }

    /**
     * what is this function-like thing's short name?
     *
     * this will be the name, minus any enclosing namespace or classname
     *
     * @return string
     */
    public function getShortName()
    {

    }

    /**
     * which line on $this->getFilename() does this function-like thing's
     * code start on?
     *
     * @return int|false
     *         - `int` if this was defined in a file
     *         - `false` otherwise
     */
    public function getStartLine()
    {

    }

    /**
     * get a list of static variables defined inside this function-like
     * thing
     *
     * @return array
     *         - key is the static variable name
     *         - value is the static variable's default value
     */
    public function getStaticVariables()
    {

    }

    /**
     * does this function-like thing define a return type?
     *
     * @return boolean
     *         - `true` if one is defined
     *         - `false` otherwise
     */
    public function hasReturnType()
    {

    }

    /**
     * is this function-like thing defined inside a namespace?
     *
     * @return boolean
     *         - `true` if is defined in a namespace
     *         - `false` otherwise
     */
    public function inNamespace()
    {

    }

    /**
     * is this function-like thing defined as a closure?
     *
     * @return boolean
     *         - `true` if this is a closure
     *         - `false` otherwise
     */
    public function isClosure()
    {

    }

    /**
     * is this function-like thing deprecated?
     *
     * @return boolean
     *         - `true` if this is deprecated
     *         - `false` otherwise
     */
    public function isDeprecated()
    {

    }

    /**
     * does this function-like thing yield at all?
     *
     * @return boolean
     *         - `true` if it yields
     *         - `false` otherwise
     */
    public function isGenerator()
    {

    }

    /**
     * is this defined by PHP, or a PHP extension?
     *
     * @return boolean
     *         - `true` if it is internal
     *         - `false` otherwise
     */
    public function isInternal()
    {

    }

    /**
     * has this function-like thing been defined by a user's PHP code?
     *
     * @return boolean
     */
    public function isUserDefined()
    {

    }

    /**
     * does this function-like thing have a variadic parameter?
     *
     * @return boolean
     *         - `true` if it does
     *         - `false` otherwise
     */
    public function isVariadic()
    {

    }

    /**
     * does this function-like thing return a reference?
     *
     * @return boolean
     *         - `true` if it does
     *         - `false` otherwise
     */
    public function returnsReference()
    {

    }

    /**
     * return a representation of this function-like thing
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

    // ==================================================================
    //
    // BetterReflection API
    //
    // ------------------------------------------------------------------

}