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
 * a more insightful ReflectionType, using our Deep Reflection data
 */
interface ReflectionType
{
    // ==================================================================
    //
    // PHP.net API
    //
    // ------------------------------------------------------------------

    /**
     * is this an array? something that can be passed into PHP array_xxx()
     * functions?
     *
     * @return boolean
     *         - `true` if this is a PHP array
     *         - `false` otherwise
     */
    public function isArray();

    /**
     * is this a PHP callable?
     *
     * @return boolean
     *         - `true` if this is `callable`
     *         - `false` otherwise
     */
    public function isCallable();

    /**
     * is this a built-in or user-defined class or interface?
     *
     * @return boolean
     */
    public function isClassLike();

    /**
     * is this a built-in or user-defined class?
     *
     * @return boolean
     */
    public function isClass();

    /**
     * does this type support array-index access?
     *
     * @return boolean
     *         - `true` if this is a PHP array
     *         - `true` if this is an object that implements ArrayAccess
     *         - `false` otherwise
     */
    public function isIndexable();

    /**
     * can this be used in a foreach() loop?
     *
     * @return boolean
     */
    public function isIterable();

    /**
     * is this a built-in or user-defined interface?
     *
     * @return boolean
     */
    public function isInterface();

    /**
     * is this PHP's `null`?
     *
     * @return boolean
     */
    public function isNull();

    /**
     * is this a numeric type?
     *
     * @return boolean
     */
    public function isNumeric();

    /**
     * is this a scalar type?
     *
     * scalar types are:
     *
     * - double
     * - int
     * - string
     *
     * @return boolean
     */
    public function isScalar();

    /**
     * is this a string?
     *
     * @return boolean
     */
    public function isString();

    /**
     * is this a built-in or user-defined trait?
     *
     * @return boolean
     */
    public function isTrait();

    // ==================================================================
    //
    // DeepReflection API
    //
    // ------------------------------------------------------------------

    /**
     * which composer project defines this type?
     *
     * @return ReflectionComposerPackage|null
     */
    public function getComposerProject();

    /**
     * which composer project defines this type?
     *
     * @return string|false
     */
    public function getComposerProjectName();
}