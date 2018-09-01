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
 * @link      https://ganbarodigital.github.io/php-mv-deep-reflection
 */

use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\PhpReflection;

/**
 * does the context contain a named class?
 *
 * @param  PhpClassContainer $context
 *         the context to examine
 * @param  string $className
 *         which class are you looking for?
 * @return boolean
 *         - `true` if the context contains the named class
 *         - `false` otherwise
 */
function dr_has_class(PhpContexts\PhpClassContainer $context, string $className) : bool
{
    return PhpReflection\HasClassCalled::check($context, $className);
}

/**
 * does the context contain any classes at all?
 *
 * @param  PhpClassContainer $context
 *         the context to examine
 * @return boolean
 *         `true` if the context has at least one class defined
 *         `false` otherwise
 */
function dr_has_classes(PhpContexts\PhpClassContainer $context) : bool
{
    return PhpReflection\HasClasses::check($context);
}

/**
 * does the context have all our named classes?
 *
 * @param  PhpClassContainer $context
 *         the context to examine
 * @param  array $classNames
 *         the list of classes to check for
 * @return bool
 *         - `true` if all the classes are in `$context`
 *         - `false` otherwise
 */
function dr_has_classes_called(PhpContexts\PhpClassContainer $context, array $classNames) : bool
{
    return PhpReflection\HasClassesCalled::check($context, $classNames);
}

/**
 * return a list of all classes from a particular context
 *
 * @param  PhpContexts\PhpClassContainer $context
 *         the context to examine
 * @return PhpContexts\PhpClass[]
 */
function dr_get_all_classes(PhpContexts\PhpClassContainer $context) : array
{
    return PhpReflection\GetAllClasses::from($context);
}

/**
 * return a list of all functions from a particular context
 *
 * @param  PhpContexts\PhpFunctionContainer $context
 *         the context to examine
 * @return PhpContexts\PhpFunction[]
 */
function dr_get_all_functions(PhpContexts\PhpFunctionContainer $context) : array
{
    return PhpReflection\GetAllFunctions::from($context);
}

/**
 * return a named class from a particular context
 *
 * @param  PhpContexts\PhpClassContainer $context
 *         the context to examine
 * @param  string $className
 *         which class do you want to get?
 * @return PhpContexts\PhpClass
 */
function dr_get_class(PhpContexts\PhpClassContainer $context, string $className) : PhpContexts\PhpClass
{
    return PhpReflection\GetClass::from($context);
}

/**
 * get a list of all the classes in the given context
 *
 * @param  PhpClassContainer $context
 *         the context to extract from
 * @return string[]
 */
function dr_get_class_names(PhpContexts\PhpClassContainer $context) : array
{
    return PhpReflection\GetClassNames::from($context);
}

/**
 * return a named function from a particular context
 *
 * @param  PhpContexts\PhpFunctionContainer $context
 *         the context to examine
 * @param  string $funcName
 *         which function do you want?
 * @return PhpContexts\PhpFunction
 */
function dr_get_function(PhpContexts\PhpFunctionContainer $context, string $funcName) : PhpContexts\PhpFunction
{
    return PhpReflection\GetFunction::from($context);
}

/**
 * get a list of all the functions in the given context
 *
 * @param  PhpContexts\PhpFunctionContainer $context
 *         the context to extract from
 * @return string[]
 */
function dr_get_function_names(PhpContexts\PhpFunctionContainer $context) : array
{
    return PhpReflection\GetFunctionNames::from($context);
}

/**
 * return a named interface from a particular context
 *
 * @param  PhpContexts\PhpInterfaceContainer $context
 *         the context to examine
 * @param  string $interfaceName
 *         which interface do you want?
 * @return PhpContexts\PhpInterface
 */
function dr_get_interface(PhpContexts\PhpInterfaceContainer $context, string $interfaceName) : PhpContexts\PhpInterface
{
    return PhpReflection\GetInterface::from($context);
}

/**
 * get a list of all the interfaces in the given context
 *
 * @param  PhpContexts\PhpInterfaceContainer $context
 *         the context to extract from
 * @return string[]
 */
function dr_get_interface_names(PhpContexts\PhpInterfaceContainer $context) : array
{
    return PhpReflection\GetInterfaceNames::from($context);
}

/**
 * return a named namespace from a particular context
 *
 * @param  PhpContexts\PhpNamespaceContainer $context
 *         the context to examine
 * @param  string $namespaceName
 *         which namespace do you want?
 * @return PhpContexts\PhpNamespace
 */
function dr_get_namespace(PhpContexts\PhpNamespaceContainer $context, string $namespaceName) : PhpContexts\PhpNamespace
{
    return PhpReflection\GetNamespace::from($context, $namespaceName);
}

/**
 * get a list of all the namespaces in the given context
 *
 * @param  PhpContexts\PhpNamespaceContainer $context
 *         the context to extract from
 * @return string[]
 */
function dr_get_namespace_names(PhpContexts\PhpNamespaceContainer $context) : array
{
    return PhpReflection\GetNamespaceNames::from($context);
}

/**
 * return a named trait from a particular context
 *
 * @param  PhpContexts\PhpTraitContainer $context
 *         the context to examine
 * @param  string $traitName
 *         which trait do you want?
 * @return PhpContexts\PhpTrait
 */
function dr_get_trait(PhpContexts\PhpTraitContainer $context, string $traitName) : PhpContexts\PhpTrait
{
    return PhpReflection\GetTrait::from($context, $traitName);
}
