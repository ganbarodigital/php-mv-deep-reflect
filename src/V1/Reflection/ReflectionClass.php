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
 * PHP's ReflectionClass, using our Deep Reflection data
 */
class ReflectionClass
{
    const IS_IMPLICIT_ABSTRACT = 1;
    const IS_EXPLICIT_ABSTRACT = 2;
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

    public static function export()
    {
        // DO NOT SUPPORT
    }

    /**
     * returns the value of a defined class constant
     *
     * @param  string $name
     *         the constant to get
     * @return mixed
     *         the value of the constant
     * @throws something
     *         if the class does not have that constant
     */
    public function getConstant($name)
    {

    }

    /**
     * returns all constants defined in the class, regardless of visibility
     *
     * @return array
     */
    public function getConstants()
    {

    }

    /**
     * returns the constructor of the reflected class
     *
     * @return ReflectionMethod|null
     */
    public function getConstructor()
    {

    }

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

    }

    /**
     * get the docblock for a class
     *
     * @return string|false
     */
    public function getDocComment()
    {

    }

    /**
     * get the line number where the class's definition ends
     *
     * @return int|false
     *         - `int` if the line number is known
     *         - `false` otherwise
     */
    public function getEndLine()
    {

    }

    /**
     * which extension defines this class?
     *
     * @return \ReflectionExtension|null
     */
    public function getExtension()
    {
        // we do not support classes defined in extensions
        return null;
    }

    /**
     * which extension defines this class?
     *
     * @return string|false
     */
    public function getExtensionName()
    {
        // we do not support classes defined in extensions
        return false;
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
     * get more details about a given method
     *
     * @param  string $name
     *         the method to learn more about
     * @return ReflectionMethod
     */
    public function getMethod($name)
    {

    }

    /**
     * gets a list of methods, with an optional filter applied
     *
     * @param  integer $filter
     *         bit-wise list:
     *         - ReflectionModifier::IS_STATIC
     *         - ReflectionModifier::IS_PUBLIC
     *         - ReflectionModifier::IS_PROTECTED
     *         - ReflectionModifier::IS_PRIVATE
     *         - ReflectionModifier::IS_ABSTRACT
     *         - ReflectionModifier::IS_FINAL
     *         - ReflectionModifier::NOT_STATIC
     *         - ReflectionModifier::NOT_INSTANCE
     *         - ReflectionModifier::NOT_ABSTRACT
     *         - ReflectionModifier::NOT_FINAL
     *         - ReflectionModifier::IS_INHERITED
     *         - ReflectionModifier::NOT_INHERITED
     *         - ReflectionModifier::FROM_INTERFACE
     *         - ReflectionModifier::NOT_FROM_INTERFACE
     *         - ReflectionModifier::FROM_TRAIT
     *         - ReflectionModifier::NOT_FROM_TRAIT
     * @return ReflectionMethod[]
     */
    public function getMethods($filter = 0)
    {

    }

    /**
     * get a list of the access modifiers
     *
     * @return int
     *         bitwise list of:
     *         - ReflectionModifier::IS_IMPLICIT_ABSTRACT
     *         - ReflectionModifier::IS_EXPLICIT_ABSTRACT
     *         - ReflectionModifier::IS_FINAL
     */
    public function getModifiers()
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
     * which class does this class extend?
     *
     * @return ReflectionClass|null
     */
    public function getParentClass()
    {

    }

    /**
     * get a list of properties defined by this class
     *
     * @param  integer $filter
     *         bitwise list of:
     *         - ReflectionModifier::IS_STATIC
     *         - ReflectionModifier::IS_PUBLIC
     *         - ReflectionModifier::IS_PROTECTED
     *         - ReflectionModifier::IS_PRIVATE
     *         - ReflectionModifier::NOT_STATIC
     *         - ReflectionModifier::NOT_INSTANCE
     *         - ReflectionModifier::IS_INHERITED
     *         - ReflectionModifier::NOT_INHERITED
     *         - ReflectionModifier::FROM_TRAIT
     *         - ReflectionModifier::NOT_FROM_TRAIT
     * @return ReflectionProperty[]
     */
    public function getProperties($filter = 0)
    {

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

    }

    /**
     * get more details about all the class constants
     *
     * @return ReflectionClassConstant[]
     */
    public function getReflectionConstants()
    {

    }

    /**
     * get the class's name, without the namespace part
     *
     * @return string
     */
    public function getShortName()
    {

    }

    /**
     * which line on $this->getFilename() does this class's code start on?
     *
     * @return int|false
     *         - `int` if this class was defined in a file
     *         - `false` otherwise
     */
    public function getStartLine()
    {

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

    }

    /**
     * get the value of a static property defined by this class
     *
     * @param  string $name
     *         the property you want the value of
     * @return mixed
     *         the value of the property
     * @throws NoSuchProperty
     *         if the property has not been defined
     */
    public function getStaticPropertyValue($name)
    {

    }

    /**
     * return a list of the trait aliases used in this class
     *
     * @return array
     */
    public function getTraitAliases()
    {

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

    }

    /**
     * does this class define this method?
     *
     * @param  string $name
     *         the method to check for
     * @return boolean
     *         - `true` if the method is defined
     *         - `false` otherwise
     */
    public function hasMethod($name)
    {

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
     * is this class defined in this namespace?
     *
     * @param  string $namespaceName
     *         the namespace to check for
     * @return boolean
     *         - `true` if this class is defined in the namespace
     *         - `false` otherwise
     */
    public function inNamespace($namespaceName)
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

    }

    /**
     * is this class defined by an extension, or core PHP?
     *
     * @return boolean
     *         - `true` if the class is defined by an extension or core PHP
     *         - `false` otherwise
     */
    public function isInternal()
    {

    }

    /**
     * can we do a `foreach()` loop over an instance of this class?
     *
     * @return boolean
     *         - `true` if we can
     *         - `false` otherwise
     */
    public function isIterateable()
    {

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

    }

    /**
     * is this class defined by a user?
     *
     * @return boolean
     *         - `false` if this class is defined by core PHP
     *         - `false` if this class is defined in a PHP extension
     *         - `true` otherwise
     */
    public function isUserDefined()
    {

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

    /**
     * get the docblock for a class
     *
     * @return ReflectionDocBlock|null
     */
    public function getDocblock()
    {

    }

    /**
     * which composer project defines this class?
     *
     * @return ReflectionComposerPackage|null
     */
    public function getComposerProject()
    {

    }

    /**
     * which composer project defines this class?
     *
     * @return string|false
     */
    public function getComposerProjectName()
    {

    }

    /**
     * which namespace is this class defined in?
     *
     * @return ReflectionNamespace
     */
    public function getNamespace()
    {

    }
}