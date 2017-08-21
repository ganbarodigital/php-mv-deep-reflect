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

namespace GanbaroDigital\DeepReflection\V1\Reflectors\PHP;

use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Contexts;
use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node\MethodDeclaration;
use Microsoft\PhpParser\Node\Statement as Statements;
use Microsoft\PhpParser\Node as Nodes;

/**
 * understand a method declaration
 */
class ReflectParameterDeclarationList
{
    /**
     * understand a method declaration
     *
     * @param  Nodes\MethodDefintion $node
     *         the AST that declares the method
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return Contexts\ClassContext
     *         our understanding about the class
     */
    public static function from(Nodes\DelimitedList\ParameterDeclarationList $node, Scope $activeScope) : Contexts\FunctionLikeParameterContext
    {
        // what's hiding inside?
        foreach ($node->getChildNodes() as $childNode)
        {
            // echo '--- ' . get_class($childNode) . PHP_EOL;
            switch (true) {
                case $childNode instanceof Nodes\Parameter:
                    return self::inspectParameterNode($childNode, $activeScope);
            }
        }

        // all done
        // return $retval;
    }

    /**
     * find all the things that our class contains
     *
     * @param  Nodes\ClassMembersNode $node
     *         the container to examine
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return void
     */
    public static function inspectParameterNode(Nodes\Parameter $node, Scope $activeScope)
    {
        // what is the parameter called?
        $name = Helpers\GetTokenText::from($node, $node->variableName);

        // does it have a type-hint at all?
        $typeHint = Helpers\GetTokenText::from($node, $node->typeDeclaration);

        // is it passed by reference?
        $passByReference = Helpers\GetTokenText::from($node, $node->byRefToken, false) ? true : false;

        // does it have a default value?
        $hasDefaultValue = false;
        $defaultValue = null;
        if ($node->equalsToken) {
            $defaultValue = Helpers\GetTokenText::from($node, $node->default);
            $hasDefaultValue = true;
        }

        // is the parameter variadic?
        $isVariadic = $node->dotDotDotToken ? true : false;

        // putting it all together
        $retval = new Contexts\FunctionLikeParameterContext(
            $typeHint,
            $passByReference,
            $isVariadic,
            $name,
            $hasDefaultValue,
            $defaultValue
        );

        // all done
        return $retval;
    }
}