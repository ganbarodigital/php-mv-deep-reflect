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
 * @package   DeepReflection/Reflectors
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\Reflectors;

use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Contexts;
use GanbaroDigital\DeepReflection\V1\Helpers;
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
     * @return Contexts\ClassLikeConstantContext
     *         our understanding about the property
     */
    public static function from(Nodes\ClassConstDeclaration $node, Scope $activeScope) : Contexts\ClassLikeConstantContext
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
     * @return Contexts\ClassLikeConstantContext
     */
    protected static function inspectElementList(Nodes\ClassConstDeclaration $node, Nodes\DelimitedList\ConstElementList $list, Scope $activeScope) : Contexts\ClassLikeConstantContext
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
     * @return Contexts\ClassLikeConstantContext
     */
    protected static function inspectElement(Nodes\ClassConstDeclaration $node, Nodes\ConstElement $element, Scope $activeScope) : Contexts\ClassLikeConstantContext
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
        $retval = new Contexts\ClassLikeConstantContext($securityScope, $constName, $defaultValue);

        // does it have a docblock?
        Helpers\AttachLeadingComment::using($node, $retval, $activeScope);

        // all done
        return $retval;
    }
}