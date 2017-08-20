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
 * @package   DeepReflection/Contexts
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\Contexts;

use GanbaroDigital\DeepReflection\V1\Exceptions\UnsupportedContext;

/**
 * container for everything in a given source file
 */
class SourceFileContext implements Context
{
    /**
     * which namespace is this file part of?
     *
     * @var NamespaceContext | null
     */
    protected $namespace = null;

    /**
     * what namespaced items are we importing into our context?
     *
     * @var array
     */
    protected $namespacedImports = [];

    /**
     * which classes are defined in this source file?
     *
     * @var array
     */
    protected $classes = [];

    /**
     * which functions are defined in this source file?
     *
     * @var array
     */
    protected $functions = [];

    /**
     * which interfaces are defined in this source file?
     *
     * @var array
     */
    protected $interfaces = [];

    /**
     * which traits are defined in this source file?
     *
     * @var array
     */
    protected $traits = [];

    /**
     * the docblock at the top of the file
     *
     * this normally contains the license text and some metadata about
     * the author, the project the file belongs to, and so on
     *
     * @var string|null
     */
    protected $comment;

    /**
     * add something to our scope
     *
     * @param  Context $context
     *         the context that we want to add
     * @return void
     */
    public function attachChildContext(Context $context)
    {
        switch(true) {
            case $context instanceof ClassContext:
                $this->classes[$context->getName()] = $context;
                break;

            case $context instanceof FunctionContext:
                $this->functions[$context->getName()] = $context;
                break;

            case $context instanceof InterfaceContext:
                $this->interfaces[$context->getName()] = $context;
                break;

            case $context instanceof TraitContext:
                $this->traits[$context->getName()] = $context;
                break;

            case $context instanceof ClassLikeConstantContext:
            case $context instanceOf FunctionLikeParameterContext:
            case $context instanceof MethodContext:
            case $context instanceof PropertyContext:
                // do nothing
                break;

            case $context instanceof NamespaceContext:
                $this->namespace = $context;
                break;

            case $context instanceof NamespacedImportContext:
                // shorthand
                $importName = $context->getShortName();

                // if we have a clash (because of a bug in the PHP code
                // that we are inspecting) only the first one counts!
                if (!isset($this->namespacedImports[$importName])) {
                    $this->namespacedImports[$importName] = $context;
                }
                break;

            case $context instanceof DocblockContext:
                $this->comment = $context;
                break;

            default:
                throw new UnsupportedContext($context, __FUNCTION__);
        }
    }

    /**
     * add a context that we belong to
     *
     * @param  Context $context
     *         our parent's context
     * @return void
     */
    public function attachParentContext(Context $context)
    {
        switch(true) {
            default:
                throw new UnsupportedContext($context, __FUNCTION__);
        }
    }

    // ==================================================================
    //
    // GET INFORMATION ABOUT THIS CONTEXT
    //
    // ------------------------------------------------------------------

    /**
     * return the PHP namespace for this context
     *
     * @return string | null
     *         - string is empty if this is part of the global scope
     *         - NULL if there is no namespace context available
     */
    public function getContainingNamespace()
    {
        return $this->namespace;
    }

    /**
     * return the docblock for a context - if there is one!
     *
     * @return DocblockContext|null
     */
    public function getDocblock()
    {
        if ($this->comment instanceof DocblockContext) {
            return $this->comment;
        }

        return null;
    }

    /**
     * return the source file where we were defined
     *
     * @return SourceFileContext
     */
    public function getSourceFile() : SourceFileContext
    {
        return $this;
    }

    public function isEmpty()
    {
        if ($this->namespace !== null) {
            return false;
        }

        if (!empty($this->namespacedImports)) {
            return false;
        }

        if (!empty($this->comment)) {
            return false;
        }

        if (!empty($this->classes)) {
            return false;
        }

        if (!empty($this->functions)) {
            return false;
        }

        return true;
    }
}
