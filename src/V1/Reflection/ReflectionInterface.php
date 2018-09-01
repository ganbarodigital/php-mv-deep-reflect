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
 * PHP's missing ReflectionInterface, using our Deep Reflection data
 */
class ReflectionInterface
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
     * get the default / initial values of a class's properties
     *
     * All properties are returned:
     *
     * - public, protected, private properties
     * - static and non-static properties too
     *
     * Properties without an explicit default value get the value `null`
     *
     * @return array
     */
    public function getDefaultProperties()
    {
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
        return 0;
    }

    /**
     * get a list of properties defined by this class
     *
     * @param  integer $filter
     *         bitwise list of:
     *         - ReflectionProperty::IS_STATIC
     *         - ReflectionProperty::IS_PUBLIC
     *         - ReflectionProperty::IS_PROTECTED
     *         - ReflectionProperty::IS_PRIVATE
     *         - ReflectionProperty::NOT_STATIC
     *         - ReflectionProperty::NOT_INSTANCE
     *         - ReflectionProperty::IS_INHERITED
     *         - ReflectionProperty::NOT_INHERITED
     *         - ReflectionProperty::FROM_TRAIT
     *         - ReflectionProperty::NOT_FROM_TRAIT
     * @return ReflectionProperty[]
     */
    public function getProperties($filter = 0)
    {
        // interfaces do not have properties
        return [];
    }

    /**
     * get more details about a specific property
     *
     * @param  string $name
     *         the property you want details about
     * @return ReflectionProperty|null
     */
    public function getProperty($name)
    {
        // interfaces do not have properties
        throw new Exceptions\NoSuchProperty($this->getName(), $name);
    }

    /**
     * get the static properties defined by this class
     *
     * @return array
     *         - key is the name of the property
     *         - value is the default value of the property
     */
    public function getStaticProperties()
    {
        // interfaces do not have static properties?
        return [];
    }

    /**
     * get the value of a static property defined by this class
     *
     * @param  string $name
     *         the property you want the value of
     * @return mixed
     *         the value of the property
     * @throws NoSuchStaticProperty
     *         if the property has not been defined
     */
    public function getStaticPropertyValue($name)
    {
        throw Exceptions\NoSuchStaticProperty($this->getName(), $name);
    }

    /**
     * return a list of the trait aliases used in this class
     *
     * @return array
     */
    public function getTraitAliases()
    {
        // interfaces do not have traits
        return [];
    }

    /**
     * return a list of the traits used by this class
     *
     * does not include traits used by parent classes
     *
     * @return array
     */
    public function getTraitNames()
    {
        // interfaces do not have traits
        return [];
    }

    /**
     * return a list of the traits used by this class
     *
     * does not include traits used by parent classes
     *
     * @return ReflectionTrait[]
     */
    public function getTraits()
    {
        // interfaces do not have traits
        return [];
    }

    /**
     * does this class define this property?
     *
     * @param  string $name
     *         the property to check for
     * @return boolean
     *         - `true` if the property is defined
     *         - `false` otherwise
     */
    public function hasProperty($name)
    {
        // interfaces do not have properties
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
        // interfaces cannot be abstract
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
        // interfaces cannot be anonymous
        return false;
    }

    /**
     * can this class be cloned?
     *
     * it checks for:
     * - a public `__clone()` method
     * - or no `__clone()` method defined
     *
     * @return boolean
     *         - `true` if this class can be cloned
     *         - `false` otherwise
     */
    public function isCloneable()
    {
        // interfaces cannot be cloned
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
        // interfaces cannot be marked as final
        return false;
    }

    /**
     * can this class be instantiated?
     *
     * it checks for:
     *
     * - a public `__construct()` method
     * - or no `__construct()` method
     *
     * @return boolean
     *         - `true` if it can
     *         - `false` otherwise
     */
    public function isInstantiable()
    {
        // interfaces cannot be instantiated
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
        // yes we are
        return true;
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
        // we are an interface, not a trait
        return false;
    }

    /**
     * return a representation of this class
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
}