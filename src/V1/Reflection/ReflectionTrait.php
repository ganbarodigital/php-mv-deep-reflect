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
 * @package   DeepReflection/Reflection
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\Reflection;

use GanbaroDigital\DeepReflection\V1\Contexts;

/**
 * PHP's missing ReflectionTrait, using our Deep Reflection data
 */
class ReflectionTrait extends ReflectionClass
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
     * returns the value of a defined class constant
     *
     * @param  string $name
     *         the constant to get
     * @return mixed
     *         the value of the constant
     * @throws NoSuchClassConstant
     *         if the class does not have that constant
     */
    public function getConstant($name)
    {
        // traits cannot have class constants
        throw new Exceptions\NoSuchClassConstant($this->getName(), $name);
    }

    /**
     * returns all constants defined in the class, regardless of visibility
     *
     * @return array
     */
    public function getConstants()
    {
        // traits cannot have class constants
        return [];
    }

    /**
     * which interfaces does this class implement?
     *
     * this will include interfaces implemented by parent classes!
     *
     * @return array
     */
    public function getInterfaceNames()
    {
        // traits cannot implement interfaces
        return [];
    }

    /**
     * which interfaces does this class implement?
     *
     * this will include interfaces implemented by parent classes!
     *
     * @return ReflectionInterface[]
     */
    public function getInterfaces()
    {
        // traits cannot implement interfaces
        return [];
    }

    /**
     * get a list of the access modifiers
     *
     * @return int
     *         bitwise list of:
     *         - ReflectionClass::IS_IMPLICIT_ABSTRACT
     *         - ReflectionClass::IS_EXPLICIT_ABSTRACT
     *         - ReflectionClass::IS_FINAL
     */
    public function getModifiers()
    {
        // you cannot set modifiers on a trait
        return 0;
    }

    /**
     * which class does this class extend?
     *
     * @return ReflectionClass|null
     */
    public function getParentClass()
    {
        // traits cannot extend anything
        return null;
    }

    /**
     * get more details about a class constant
     *
     * @param  string $name
     *         the constant you want more details about
     * @return ReflectionClassConstant|null
     */
    public function getReflectionConstant($name)
    {
        // traits cannot define constants
        throw new Exceptions\NoSuchClassConstant($this->getName(), $name);
    }

    /**
     * get more details about all the class constants
     *
     * @return ReflectionClassConstant[]
     */
    public function getReflectionConstants()
    {
        // traits cannot define constants
        return [];
    }

    /**
     * does this class define this constant?
     *
     * @param  string $name
     *         the constant to check for
     * @return boolean
     *         - `true` if the constant is defined
     *         - `false` otherwise
     */
    public function hasConstant($name)
    {
        // traits cannot define constants
        return false;
    }

    /**
     * does this class implement this interface?
     *
     * @param  string $interfaceName
     *         the interface to check for
     * @return boolean
     *         - `true` if this class (or its parents) implements the interface
     *         - `false` otherwise
     */
    public function implementsInterface($interfaceName)
    {
        // traits cannot implement interfaces
        return false;
    }

    /**
     * is this class abstract?
     *
     * @return boolean
     *         - `true` if this class is explicitly abstract
     *         - `true` if this class is implicitly abstract
     *         - `false` otherwise
     */
    public function isAbstract()
    {
        // traits cannot be abstract
        return false;
    }

    /**
     * is this an anonymous class?
     *
     * @return boolean
     *         - `true` if this class is anonymous
     *         - `false` otherwise
     */
    public function isAnonymous()
    {
        // traits cannot be anonymous
        return false;
    }

    /**
     * is this class marked as `final`?
     *
     * @return boolean
     *         - `true` if this class is marked as `final`
     *         - `false` otherwise
     */
    public function isFinal()
    {
        // traits cannot be marked as final
        return false;
    }

    /**
     * is this class an interface?
     *
     * @return boolean
     *         - `true` if it is an interface
     *         - `false` otherwise
     */
    public function isInterface()
    {
        // we are a trait, not an interface
        return false;
    }

    /**
     * do we (or our parents) extend a given class or implement a given
     * interface?
     *
     * @param  string $classname
     *         the class|interface name to check
     * @return boolean
     *         - `true` if we do extend a given class
     *         - `true` if we do implement a given interface
     *         - `false` otherwise
     */
    public function isSubclassOf($classname)
    {
        // traits cannot be subclasses of anything
        return false;
    }

    /**
     * is this class a trait?
     *
     * @return boolean
     *         - `true` if it is a trait
     *         - `false` otherwise
     */
    public function isTrait()
    {
        // yes we are :)
        return true;
    }

    /**
     * return a representation of this class
     *
     * @return string
     */
    public function __toString()
    {

    }
}