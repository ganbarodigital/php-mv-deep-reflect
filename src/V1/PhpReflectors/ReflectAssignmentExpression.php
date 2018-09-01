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
use GanbaroDigital\DeepReflection\V1\PhpScopes\PhpScope;
use Microsoft\PhpParser\Node\MethodDeclaration;
use Microsoft\PhpParser\Node\Statement as Statements;
use Microsoft\PhpParser\Node as Nodes;

/**
 * understand a PHP assignment expression
 */
class ReflectAssignmentExpression
{
    /**
     * understand a PHP assignment expression
     *
     * @param  Nodes\Expression\AssignmentExpression $node
     *         the AST that declares the expression
     * @param  PhpScope $activeScope
     *         keeping track of where we are as we inspect things
     * @return PhpContexts\PhpExpression
     *         our understanding about the assignment
     */
    public static function from(Nodes\Expression\AssignmentExpression $node, PhpScope $activeScope) : PhpContexts\PhpExpression
    {
        // what do we have?
        $lhs = Helpers\GetTokenText::from($node, $node->leftOperand);
        $rhs = Helpers\GetTokenText::from($node, $node->rightOperand);

        $retval = new PhpContexts\PhpExpression($lhs, '=', $rhs);
        return $retval;
    }
}