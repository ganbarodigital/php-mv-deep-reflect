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
 * @package   DeepReflection/PhpReflectors
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\PhpReflectors;

use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node\Statement\ClassDefinition;
use Microsoft\PhpParser\Node\Statement as Statements;
use Microsoft\PhpParser\Node as Nodes;

/**
 * understand a class declaration
 */
class ReflectClassDeclaration
{
    /**
     * understand a class declaration
     *
     * @param  Statements\ClassDefintion $node
     *         the AST that declares the class
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return PhpContexts\ClassContext
     *         our understanding about the class
     */
    public static function from(Statements\ClassDeclaration $node, Scope $activeScope) : PhpContexts\ClassContext
    {
        // what is our parent's namespace?
        $namespaceCtx = $activeScope->getNamespace();
        $namespace = $namespaceCtx ? $namespaceCtx->getContainingNamespace() : null;

        // what is this class called?
        $classname = $node->name->getText($node->parent->fileContents);

        // put the two together
        if (is_string($namespace) && strlen($namespace) > 0) {
            $fqcn = $namespace . '\\' . $classname;
        }
        else {
            $fqcn = $classname;
        }

        // now we can create the class itself
        $retval = new PhpContexts\ClassContext($fqcn);

        // does it have a docblock?
        Helpers\AttachLeadingComment::using($node, $retval, $activeScope);

        // now that we have a class, our active scope has changed!
        $activeScope = $activeScope->withClass($retval);

        foreach ($node->getChildNodes() as $childNode)
        {
            // echo get_class($childNode) . PHP_EOL;
            switch (true) {
                case $childNode instanceof Nodes\ClassMembersNode:
                    self::inspectMembersNode($childNode, $activeScope, $retval);
            }
        }

        // all done
        return $retval;
    }

    /**
     * find all the things that our class contains
     *
     * @param  Nodes\ClassMembersNode $node
     *         the container to examine
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @param  PhpContexts\ClassContext $retval
     *         the class we are learning about
     * @return void
     */
    protected static function inspectMembersNode(Nodes\ClassMembersNode $node, Scope $activeScope, PhpContexts\ClassContext $retval)
    {
        foreach ($node->getChildNodes() as $childNode)
        {
            // echo "- " . get_class($childNode) . PHP_EOL;
            switch (true) {
                case $childNode instanceof Nodes\ClassConstDeclaration:
                    $constCtx = ReflectClassConstantDeclaration::from($childNode, $activeScope);
                    Helpers\AttachToParents::using($constCtx, $activeScope);
                    break;

                case $childNode instanceof Nodes\PropertyDeclaration:
                    $propCtx = ReflectPropertyDeclaration::from($childNode, $activeScope);
                    Helpers\AttachToParents::using($propCtx, $activeScope);
                    break;

                case $childNode instanceof Nodes\MethodDeclaration:
                    $methodCtx = ReflectMethodDeclaration::from($childNode, $activeScope);
                    Helpers\AttachToParents::using($methodCtx, $activeScope);
                    break;
            }
        }
    }
}