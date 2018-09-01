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

namespace GanbaroDigital\DeepReflection\V1\PhpReflectors;

use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node\MethodDeclaration;
use Microsoft\PhpParser\Node\Statement as Statements;
use Microsoft\PhpParser\Node as Nodes;

/**
 * understand a constant declaration in a class-like context
 */
class ReflectClassConstantDeclaration
{
    /**
     * understand a constant declaration in a class-like context
     *
     * @param  Nodes\ClassConstDeclaration $node
     *         the AST that declares the constant
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return PhpContexts\PhpClassLikeConstant
     *         our understanding about the property
     */
    public static function from(Nodes\ClassConstDeclaration $node, Scope $activeScope) : PhpContexts\PhpClassLikeConstant
    {
        foreach ($node->getChildNodes() as $childNode) {
            switch (true) {
                case $childNode instanceof Nodes\DelimitedList\ConstElementList:
                    return self::inspectElementList($node, $childNode, $activeScope);
            }
        }
    }

    /**
     * make sense of a list of const elements
     *
     * @param  Nodes\ClassConstDeclaration $node
     * @param  Nodes\DelimitedList\ConstElementList $list
     * @param  Scope $activeScope
     * @return PhpContexts\PhpClassLikeConstant
     */
    protected static function inspectElementList(Nodes\ClassConstDeclaration $node, Nodes\DelimitedList\ConstElementList $list, Scope $activeScope) : PhpContexts\PhpClassLikeConstant
    {
        foreach ($list->getChildNodes() as $childNode) {
            switch (true) {
                case $childNode instanceof Nodes\ConstElement:
                    return self::inspectElement($node, $childNode, $activeScope);
            }
        }
    }

    /**
     * make sense of a single const element
     *
     * @param  Nodes\ClassConstDeclaration $node
     * @param  Nodes\ConstElement $list
     * @param  Scope $activeScope
     * @return PhpContexts\PhpClassLikeConstant
     */
    protected static function inspectElement(Nodes\ClassConstDeclaration $node, Nodes\ConstElement $element, Scope $activeScope) : PhpContexts\PhpClassLikeConstant
    {
        // what is this property called?
        $constName = Helpers\GetTokenText::from($element, $element->name);

        // do we have a default value?
        $defaultValue = Helpers\GetTokenText::from($element, $element->assignment);

        // let's find out what kind of modifiers it has
        $modifiers = ReflectNodeModifiers::from($node, $node->modifiers);

        // what security scope?
        $securityScope = ReflectSecurityScope::from($modifiers);

        // we can now build the property!
        $retval = new PhpContexts\PhpClassLikeConstant($securityScope, $constName, $defaultValue);

        // does it have a docblock?
        Helpers\AttachLeadingComment::using($node, $retval, $activeScope);

        // all done
        return $retval;
    }
}