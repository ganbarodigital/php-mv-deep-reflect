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
use Microsoft\PhpParser\Node\Statement\NamespaceUseDeclaration;
use Microsoft\PhpParser\Node\Statement as Statements;
use Microsoft\PhpParser\Node as Nodes;

/**
 * understand something imported via a namespace
 */
class ReflectNamespacedImport
{
    /**
     * understand something imported via a namespace
     *
     * @param  NamespaceUseDeclaration $node
     *         the AST that does the import
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return PhpContexts\PhpNamespacedImport[]
     *         our understanding about what has been imported
     */
    public static function from(NamespaceUseDeclaration $node, Scope $activeScope) : array
    {
        $retval=[];

        foreach ($node->getDescendantNodes() as $childNode)
        {
            // echo "- " . get_class($childNode) . PHP_EOL;
            switch(true) {
                case $childNode instanceof Nodes\DelimitedList\NamespaceUseClauseList:
                    $newImports = self::inspectUseClauseList($childNode, $activeScope);

                    foreach($newImports as $newImport) {
                        // does it have a docblock?
                        Helpers\AttachLeadingComment::using($childNode, $newImport, $activeScope);

                        $retval[$newImport->getInContextName()] = $newImport;
                    }
                    break;
            }
        }

        // at this point, we have a list of import or imports
        // but we don't understand what has been imported

        // all done
        return $retval;
    }

    /**
     * extract a list of imports from the AST of a use clause
     *
     * @param  Nodes\DelimitedList\NamespaceUseClauseList $nodes
     *         the AST to inspect
     * @return array
     *         a list of imports discovered
     */
    protected static function inspectUseClauseList(Nodes\DelimitedList\NamespaceUseClauseList $nodes, Scope $activeScope) : array
    {
        // our return list
        $retval = [];

        foreach ($nodes->getDescendantNodes() as $node)
        {
            // echo "-- " . get_class($node) . PHP_EOL;
            switch(true) {
                case $node instanceof Nodes\NamespaceUseClause:
                    $aliasName = $node->namespaceAliasingClause ? trim(substr($node->namespaceAliasingClause->getText(), 3)) : null;
                    $retval[] = new PhpContexts\PhpNamespacedImport($activeScope, $node->namespaceName, $aliasName);
                    break;
            }
        }

        return $retval;
    }
}