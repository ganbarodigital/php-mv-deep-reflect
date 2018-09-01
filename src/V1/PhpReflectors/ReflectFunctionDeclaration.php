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
use Microsoft\PhpParser\Node\FunctionDeclaration;
use Microsoft\PhpParser\Node\Statement as Statements;
use Microsoft\PhpParser\Node as Nodes;

/**
 * understand a function declaration
 */
class ReflectFunctionDeclaration
{
    /**
     * understand a function declaration
     *
     * @param  Nodes\FunctionDefintion $node
     *         the AST that declares the function
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return PhpContexts\PhpFunction
     *         our understanding about the function
     */
    public static function from(Statements\FunctionDeclaration $node, Scope $activeScope) : PhpContexts\PhpFunction
    {
        // what is our parent's namespace?
        $namespaceCtx = $activeScope->getNamespace();
        $namespacePrefix = $namespaceCtx->getNameAsPrefix();

        // what is this function called?
        $functionName = Helpers\GetTokenText::from($node, $node->name);

        // put the two together
        $fqfn = $namespacePrefix . $functionName;

        // what is its return type?
        $returnType = Helpers\GetTokenText::from($node, $node->returnType, null);

        // build the function
        $retval = new PhpContexts\PhpFunction($activeScope, $fqfn, $returnType);

        // the scope has now changed!
        $activeScope = $activeScope->with($retval);

        // does it have a docblock?
        Helpers\AttachLeadingComment::using($node, $retval, $activeScope);

        // find its parameters
        $params = [];
        foreach ($node->getChildNodes() as $childNode)
        {
            // echo '-- ' . get_class($childNode) . PHP_EOL;
            switch (true) {
                case $childNode instanceof Nodes\DelimitedList\ParameterDeclarationList:
                    $params[] = ReflectParameterDeclarationList::from($childNode, $activeScope);
                    break;
            }
        }

        // attach the parameters
        foreach($params as $param) {
            $retval->attachChildContext($param->getName(), $param);
        }

        // all done
        return $retval;
    }
}