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

use GanbaroDigital\DeepReflection\V1\Exceptions;
use GanbaroDigital\DeepReflection\V1\PhpScopes\PhpScope;
use GanbaroDigital\MissingBits\TypeInspectors\GetNamespace;
use GanbaroDigital\MissingBits\TypeInspectors\StripNamespace;

/**
 * container for everything that is like a class
 */
class PhpClassLike extends PhpSourceCode
  implements PhpDocblockContainer, PhpMethodContainer
{
    /**
     * what is the full name of this class?
     *
     * @var PhpClassLikeName
     */
    protected $fqcn;

    /**
     * what's the name of our namespace?
     * @var PhpNamespaceName
     */
    protected $namespaceName;

    /**
     * what's the name of our class, sans namespace?
     * @var string
     */
    protected $classname;

    /**
     * our constructor
     *
     * @param PhpClassLikeName $fqcn
     *        the fully-qualified class name
     */
    public function __construct(PhpScope $scope, PhpClassLikeName $fqcn)
    {
        parent::__construct($scope);

        $this->fqcn = $fqcn;
        $this->namespaceName = new PhpNamespaceName(GetNamespace::from((string)$fqcn));
        $this->classname = StripNamespace::from((string)$fqcn);
    }

    /**
     * what is the name of the context we represent?
     *
     * @return PhpClassLikeName
     */
    public function getName()
    {
        return $this->fqcn;
    }

    /**
     * what is the name of this class, inside our parent context?
     *
     * @return string
     */
    public function getInContextName()
    {
        return $this->classname;
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
        return 'class-like';
    }

    // ==================================================================
    //
    // Based on PHP.net API
    //
    // ------------------------------------------------------------------

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
    public function getConstantValue($name)
    {
        // shorthand
        $constantCtx = $this->getConstantContext($name);
        return $constantCtx->getValue();
    }

    /**
     * returns the names of all constants defined in the class,
     * regardless of visibility
     *
     * @return array
     */
    public function getConstants()
    {
        return array_keys($this->children[ClassLikeConstantContext::class]);
    }

    /**
     * returns the constructor of the reflected class
     *
     * @return MethodContext|null
     */
    public function getConstructor()
    {
        return $this->children[MethodContext::class]['__construct'] ?? null;
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
     * @return MethodContext
     */
    public function getMethod($name)
    {
        return $this->children[MethodContext::class][$name] ?? null;
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
     * @return MethodContext[]
     */
    public function getMethods($filter = 0)
    {
        // before we apply any filters
        $retval = $this->children[MethodContext::class];

        // reduce the list down
        //

        // all done
        return $retval;
    }

    /**
     * which class does this class extend?
     *
     * @return ClassContext|null
     */
    public function getParentClass()
    {
        return $this->children[ClassExtendsContext::class][0] ?? null;
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
        // the list, before filtering
        $retval = $this->children[PropertyContext::class];

        // filter down the list

        // all done
        return $retval;
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
        return $this->children[PropertyContext::class][$name] ?? null;
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
     * return a representation of this class
     *
     * @return string
     */
    public function __toString()
    {

    }

    // ==================================================================
    //
    // Additional Deep Reflection API
    //
    // ------------------------------------------------------------------

    /**
     * returns the value of a defined class constant
     *
     * @param  string $name
     *         the constant to get
     * @return ClassLikeConstantContext
     *         everything we know about this constant
     * @throws PhpExceptions\NoSuchClassConstant
     *         if the class does not have that constant
     */
    public function getConstantContext($name)
    {
        // shorthand
        $constantCtx = $this->children[ClassLikeConstantContext::class][$name];

        // does it exist?
        if ($constantCtx === null) {
            throw new PhpExceptions\NoSuchClassConstant($this->getName(), $name);
        }

        return $constantCtx->getValue();
    }

}
