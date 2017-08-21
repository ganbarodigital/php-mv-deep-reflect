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

use GanbaroDigital\DeepReflection\V1\Contexts;
use GanbaroDigital\DeepReflection\V1\Helpers;
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
     * @return Contexts\NamespacedImportContext[]
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

                        $retval[] = $newImport;
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
                    $retval[] = new Contexts\NamespacedImportContext($node->namespaceName, $aliasName);
                    break;
            }
        }

        return $retval;
    }
}