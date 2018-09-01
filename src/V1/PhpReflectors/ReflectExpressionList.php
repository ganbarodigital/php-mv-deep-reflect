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
 * understand an expression list
 */
class ReflectExpressionList
{
    /**
     * understand an expression list
     *
     * @param  Nodes\DelimitedList\ExpressionList $node
     *         the AST that declares the list of expressions
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return array
     *         the expression(s) that we found
     */
    public static function from(Nodes\DelimitedList\ExpressionList $node, Scope $activeScope) : array
    {
        // this will hold all the expressions that we find
        $retval = [];

        // what do we have?
        foreach($node->getChildNodes() as $childNode) {
            switch(true) {
                case $childNode instanceof Nodes\Expression\AssignmentExpression:
                    $retval[] = ReflectExpression::from($childNode, $activeScope);
                    break;

                case $childNode instanceof Nodes\Expression\Variable:
                    $retval[] = new PhpContexts\PhpExpression(Helpers\GetTokenText::from($childNode, $childNode->name), null, null);
                    break;
            }
        }

        // all done
        return $retval;
    }
}