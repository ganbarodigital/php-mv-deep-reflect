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

use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node\Statement\NamespaceDefinition;
use Microsoft\PhpParser\Node\Statement as Statements;
use Microsoft\PhpParser\Node as Nodes;

/**
 * understand a namespace declaration
 */
class ReflectNamespaceDeclaration
{
    /**
     * understand a namespace declaration
     *
     * @param  NamespaceDefintion $node
     *         the AST that declares the namespace
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return PhpContexts\PhpNamespace
     *         our understanding about the namespace
     */
    public static function from(NamespaceDefinition $node, Scope $activeScope) : PhpContexts\PhpNamespace
    {
        // we cannot create our return value until we know which namespace
        // we are looking at

        // find the namespace
        $namespaceName = null;
        foreach ($node->getChildNodes() as $childNode)
        {
            switch(true) {
                case $childNode instanceof Nodes\QualifiedName:
                    $namespaceName = $childNode->getText();
                    break;
            }
        }

        // at this point, we should have the namespace
        //
        // we don't create it ourselves - we let our global context
        // handle that
        //
        // it acts as the ultimate container of everything we have
        // seen so far
        $retval = $activeScope->getGlobalContext()->createNamespace($activeScope, $namespaceName);

        // all done
        return $retval;
    }
}