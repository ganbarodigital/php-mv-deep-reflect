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

namespace GanbaroDigital\DeepReflection\V1;

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
function has_class(PhpContexts\PhpClassContainer $context, string $className) : bool
{
    return PhpReflection\ContextHasClass::check($context, $className);
}

/**
 * return a list of all classes from a particular context
 *
 * @param  PhpContexts\PhpClassContainer $context
 *         the context to examine
 * @return array
 */
function get_all_classes(PhpContexts\PhpClassContainer $context) : array
{
    return PhpReflection\GetAllClasses::from($context);
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
function get_class(PhpContexts\PhpClassContainer $context, string $className) : PhpContexts\PhpClass
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
function get_class_names(PhpContexts\PhpClassContainer $context) : array
{
    return PhpReflection\GetClassNames::from($context);
}