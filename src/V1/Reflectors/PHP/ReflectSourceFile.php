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
use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Helpers;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Statement as Statements;
use Microsoft\PhpParser\Parser;

/**
 * what's in the source file?
 */
class ReflectSourceFile
{
    /**
     * what's in the source file?
     *
     * @param  string $filename
     *         path to this file
     * @param  Scope $activeScope
     *         keeping track of where we are as we inspect things
     * @return SourceFileContext
     *         what we've found about this file
     */
    public static function from(string $filename, Scope $activeScope) : Contexts\SourceFileContext
    {
        echo "->> {$filename}" . PHP_EOL;

        // our return value
        $retval = new Contexts\SourceFileContext($filename);

        // update our active scope
        $activeScope = $activeScope->withSourceFile($retval);

        // let's get the file parsed
        $parser = new Parser;
        $astNode = $parser->parseSourceFile(file_get_contents($filename));

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
                    Helpers\AttachToParents::using($namespaceCtx, $activeScope);

                    // check to see if our docblock is invalidated
                    if (self::checkForOurDocblock($sfDocblockCtx, $namespaceCtx)) {
                        $sfDocblockCtx = null;
                    }

                    // a namespace declaration changes the active scope!
                    $activeScope = $activeScope->withNamespace($namespaceCtx);
                    break;

                case $childNode instanceof Statements\NamespaceUseDeclaration:
                    $importCtxs = ReflectNamespacedImport::from($childNode, $activeScope);
                    foreach ($importCtxs as $importCtx) {
                        Helpers\AttachToParents::using($importCtx, $activeScope);
                    }
                    break;

                case $childNode instanceof Statements\ClassDeclaration:
                    $classCtx = ReflectClassDeclaration::from($childNode, $activeScope);
                    Helpers\AttachToParents::using($classCtx, $activeScope);

                    // check to see if our docblock is invalidated
                    if (self::checkForOurDocblock($sfDocblockCtx, $classCtx)) {
                        $sfDocblockCtx = null;
                    }

                    // the class doesn't change the active scope, as it is
                    // self-contained
                    break;

                case $childNode instanceof Statements\FunctionDeclaration:
                    $funcCtx = ReflectFunctionDeclaration::from($childNode, $activeScope);
                    Helpers\AttachToParents::using($funcCtx, $activeScope);

                    // check to see if our docblock is invalidated
                    if (self::checkForOurDocblock($sfDocblockCtx, $funcCtx)) {
                        $sfDocblockCtx = null;
                    }

                    break;

                case $childNode instanceof Statements\InterfaceDeclaration:
                    $interfaceCtx = ReflectInterfaceDeclaration::from($childNode, $activeScope);
                    Helpers\AttachToParents::using($interfaceCtx, $activeScope);

                    // check to see if our docblock is invalidated
                    if (self::checkForOurDocblock($sfDocblockCtx, $interfaceCtx)) {
                        $sfDocblockCtx = null;
                    }

                    // the interface doesn't change the active scope, as it is
                    // self-contained
                    break;

                case $childNode instanceof Statements\TraitDeclaration:
                    $traitCtx = ReflectTraitDeclaration::from($childNode, $activeScope);
                    Helpers\AttachToParents::using($traitCtx, $activeScope);

                    // check to see if our docblock is invalidated
                    if (self::checkForOurDocblock($sfDocblockCtx, $traitCtx)) {
                        $sfDocblockCtx = null;
                    }

                    // the trait doesn't change the active scope, as it is
                    // self-contained
                    break;
            }
        }

        // only now, at the very end, can we see if the file has its own
        // docblock or not
        if ($sfDocblockCtx) {
            $retval->attachChildContext($sfDocblockCtx);
            $sfDocblockCtx->attachParentContext($retval);
        }

        // all done
        return $retval;
    }

    /**
     * does another context have the same docblock that we do?
     *
     * @param  Contexts\DocblockContext|null $ourDocblockCxt
     *         what we think our docblock is
     * @param  Contexts\Context $childCtx
     *         the child that $ourDocblockCtx may actually belong to
     * @return bool
     *         - TRUE if $ourDocblockCtx actually belongs to $childCtx
     *         - FALSE otherwise
     */
    protected function checkForOurDocblock(Contexts\DocblockContext $ourDocblockCxt = null, Contexts\Context $childCtx)
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