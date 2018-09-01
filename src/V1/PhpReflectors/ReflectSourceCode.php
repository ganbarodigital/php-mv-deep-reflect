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
use GanbaroDigital\DeepReflection\V1\Context;
use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\PhpScopes;
use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement as Statements;
use Microsoft\PhpParser\Parser;

/**
 * understand a string of PHP source code
 */
class ReflectSourceCode
{
    /**
     * what's in the source file?
     *
     * @param  string $code
     *         the code to parse
     * @param  PhpScopes\PhpScope $activeScope
     *         keeping track of where we are as we inspect things
     * @param  PhpContexts\PhpContext $context
     *         the context to store what we've found
     * @return void
     */
    public static function from(string $code, PhpScopes\PhpScope $activeScope, PhpContexts\PhpContext $context)
    {
        // let's get the file parsed
        $parser = new Parser;
        $astNode = $parser->parseSourceFile($code);

        // foreach ($astNode->getDescendantNodes() as $childNode) {
        //     echo "    - " . get_class($childNode) . PHP_EOL;
        // }

        // do we have a docblock for the source file?
        //
        // we may have comments, but how do we tell which one is the
        // docblock for the whole file?
        $comments = Helpers\SeparateComments::using($astNode->getFileContents());
        $sfDocblockCtx = null;
        if (Checks\IsDocblock::check($comments[0])) {
            // we assume the first one is, *until* one of our children
            // turns up with the same docblock attached
            $sfDocblockCtx = ReflectDocblock::from($comments[0], $activeScope);
        }

        foreach ($astNode->getChildNodes() as $childNode)
        {
            // echo get_class($childNode) . PHP_EOL;

            switch(true) {
                case $childNode instanceof Statements\NamespaceDefinition:
                    $namespaceCtx = ReflectNamespaceDeclaration::from($childNode, $activeScope);
                    $namespaceName = $namespaceCtx->getName();
                    $context->attachChildContext(
                        $namespaceName,
                        $namespaceCtx
                    );
                    $activeScope->getGlobalContext()->attachChildContext(
                        $namespaceName,
                        $namespaceCtx
                    );

                    // check to see if our docblock is invalidated
                    if (self::checkForOurDocblock($sfDocblockCtx, $namespaceCtx)) {
                        $sfDocblockCtx = null;
                    }

                    // a namespace declaration changes the active scope!
                    $activeScope = $activeScope->with($namespaceCtx);
                    break;

                case $childNode instanceof Statements\NamespaceUseDeclaration:
                    $importCtxs = ReflectNamespacedImport::from($childNode, $activeScope);
                    $context->attachChildContexts($importCtxs);
                    break;

                case $childNode instanceof Statements\ClassDeclaration:
                    $classCtx = ReflectClassDeclaration::from($childNode, $activeScope);
                    self::attachChildContainer($context, $classCtx, $activeScope);
                    self::checkSourceHeaderDocblock($sfDocblockCtx, $classCtx);

                    // the class doesn't change the active scope, as it is
                    // self-contained
                    break;

                case $childNode instanceof Statements\FunctionDeclaration:
                    $funcCtx = ReflectFunctionDeclaration::from($childNode, $activeScope);
                    self::attachChildContainer($context, $funcCtx, $activeScope);
                    self::checkSourceHeaderDocblock($sfDocblockCtx, $funcCtx);

                    break;

                case $childNode instanceof Statements\InterfaceDeclaration:
                    $interfaceCtx = ReflectInterfaceDeclaration::from($childNode, $activeScope);
                    self::attachChildContainer($context, $interfaceCtx, $activeScope);
                    self::checkSourceHeaderDocblock($sfDocblockCtx, $interfaceCtx);

                    // the interface doesn't change the active scope, as it is
                    // self-contained
                    break;

                case $childNode instanceof Statements\TraitDeclaration:
                    $traitCtx = ReflectTraitDeclaration::from($childNode, $activeScope);
                    self::attachChildContainer($context, $traitCtx, $activeScope);
                    self::checkSourceHeaderDocblock($sfDocblockCtx, $traitCtx);

                    // the trait doesn't change the active scope, as it is
                    // self-contained
                    break;
            }
        }

        // only now, at the very end, can we see if the file has its own
        // docblock or not
        if ($sfDocblockCtx) {
            $context->attachChildContext(null, $sfDocblockCtx);
        }

        // all done
    }

    protected function attachChildContainer(PhpContexts\PhpContext $context, PhpContexts\PhpContext $childCtx, PhpScopes\PhpScope $activeScope)
    {
        // shorthand
        $childCtxName = $childCtx->getInContextName();

        $context->attachChildContext($childCtxName, $childCtx);
        $activeScope->getNamespace()->attachChildContext($childCtxName, $childCtx);
    }

    protected function checkSourceHeaderDocblock(PhpContexts\PhpDocblock $sfDocblockCtx = null, PhpContexts\PhpContext $childCtx)
    {
        // check to see if our docblock is invalidated
        if (self::checkForOurDocblock($sfDocblockCtx, $childCtx)) {
            $sfDocblockCtx = null;
        }

        return $sfDocblockCtx;
    }
    /**
     * does another context have the same docblock that we do?
     *
     * @param  PhpContexts\DocblockContext|null $ourDocblockCxt
     *         what we think our docblock is
     * @param  PhpContexts\Context $childCtx
     *         the child that $ourDocblockCtx may actually belong to
     * @return bool
     *         - TRUE if $ourDocblockCtx actually belongs to $childCtx
     *         - FALSE otherwise
     */
    protected function checkForOurDocblock(PhpContexts\PhpDocblock $ourDocblockCxt = null, PhpContexts\PhpContext $childCtx)
    {
        // do *we* have a docblock?
        if (!$ourDocblockCxt) {
            return;
        }

        // do they *have* a docblock?
        $childDocblockCtx = $childCtx->getDocblock();
        if (!$childDocblockCtx) {
            return;
        }

        // is it the same as ours?
        $ourText = $ourDocblockCxt->getText();
        $theirText = $childDocblockCtx->getText();

        // var_dump($ourText);
        // var_dump($theirText);
        // exit(1);

        return ($ourText == $theirText);
    }

}