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
 * understand a property declaration
 */
class ReflectPropertyDeclaration
{
    /**
     * understand a property declaration
     *
     * @param  Nodes\PropertyDeclaration $node
     *         the AST that declares the property
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return PhpContexts\PhpProperty
     *         our understanding about the property
     */
    public static function from(Nodes\PropertyDeclaration $node, Scope $activeScope) : PhpContexts\PhpProperty
    {
        // a PHP property declaration is treated as an expression
        // by the parser we are using
        //
        // to find the property's name and default value (if any), we must
        // understand the expression first
        $exprCtxs = ReflectExpressionList::from($node->propertyElements, $activeScope);

        // what is this property called?
        $propertyName = $exprCtxs[0]->getLHS();

        // do we have a default value?
        $defaultValue = $exprCtxs[0]->getRHS();

        // let's find out what kind of modifiers it has
        $modifiers = ReflectNodeModifiers::from($node, $node->modifiers);

        // what security scope?
        $securityScope = ReflectSecurityScope::from($modifiers);

        // static?
        $isStaticProp = isset($modifiers['static']) ? true : false;

        // we can now build the property!
        $retval = new PhpContexts\PhpProperty($securityScope, $isStaticProp, $propertyName, $defaultValue);

        // does it have a docblock?
        Helpers\AttachLeadingComment::using($node, $retval, $activeScope);

        // all done
        return $retval;
    }
}