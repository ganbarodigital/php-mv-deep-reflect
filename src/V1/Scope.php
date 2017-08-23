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
 * @package   DeepReflection
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1;

use GanbaroDigital\DeepReflection\V1\Contexts;

/**
 * keep track of the current active scope(s)
 */
class Scope
{
    /**
     * a full list of all the contexts that are currently active
     *
     * @var array
     */
    protected $contexts = [];

    /**
     * a subset of $contexts, suitable for attaching to at this
     * moment in time
     *
     * @var array
     */
    protected $parentContexts = [];

    /**
     * create a new active scope
     *
     * @param Contexts\GlobalContext $globalCtx
     *        the global scope for the code we are parsing
     * @param Contexts\AutoloaderContext $autoloaderCtx
     *        keep track of the autoloader instructions we come across
     */
    public function __construct(Contexts\GlobalContext $globalCtx, Contexts\AutoloaderContext $autoloaderCtx)
    {
        $this->contexts['globalCtx'] = $globalCtx;
        $this->contexts['autoloaderCtx'] = $autoloaderCtx;

        $this->parentContexts = $this->contexts;
    }

    /**
     * which parents should we be attaching to, at this moment in time?
     *
     * @return array
     */
    public function getParentContexts()
    {
        return $this->parentContexts;
    }

    /**
     * get the global context
     *
     * @return Contexts\GlobalContext
     */
    public function getGlobalContext()
    {
        return $this->contexts['globalCtx'];
    }

    /**
     * get the class that we're in
     *
     * @return Contexts\ClassContext|null
     */
    public function getClass()
    {
        return $this->contexts['classCtx'] ?? null;
    }

    /**
     * tell us which class we're currently in
     *
     * @param Contexts\ClassContext $classCtx|null
     *        the class that we're looking at
     */
    public function withClass(Contexts\ClassContext $classCtx) : Scope
    {
        $retval = clone $this;
        $retval->contexts['classCtx'] = $classCtx;

        // set up the parent contexts
        $retval->parentContexts = $retval->contexts;
        unset($retval->parentContexts['autoloaderCtx']);
        unset($retval->parentContexts['globalCtx']);
        unset($retval->parentContexts['namespaceCtx']);

        return $retval;
    }

    public function withComposerComponent(Contexts\ComposerComponentContext $composerCtx) : Scope
    {
        $retval = clone $this;
        $retval->contexts['composerCtx'] = $composerCtx;

        // setup the parent contexts
        $retval->parentContexts = $retval->contexts;

        // all done
        return $retval;
    }

    /**
     * get the function that we're in
     *
     * @return Contexts\FunctionContext|null
     */
    public function getFunction()
    {
        return $this->contexts['functionCtx'] ?? null;
    }

    /**
     * tell us which function we're currently in
     *
     * @param Contexts\FunctionContext $functionCtx|null
     *        the function that we're looking at
     */
    public function withFunction(Contexts\FunctionContext $functionCtx) : Scope
    {
        $retval = clone $this;
        $retval->contexts['functionCtx'] = $functionCtx;

        // set up the parent contexts
        $retval->parentContexts = $retval->contexts;
        unset($retval->parentContexts['autoloaderCtx']);
        unset($retval->parentContexts['globalCtx']);

        return $retval;
    }

    /**
     * get the interface that we're in
     *
     * @return Contexts\InterfaceContext|null
     */
    public function getInterface()
    {
        return $this->contexts['interfaceCtx'] ?? null;
    }

    /**
     * tell us which interface we're currently in
     *
     * @param Contexts\InterfaceContext $interfaceCtx|null
     *        the interface that we're looking at
     */
    public function withInterface(Contexts\InterfaceContext $interfaceCtx) : Scope
    {
        $retval = clone $this;
        $retval->contexts['interfaceCtx'] = $interfaceCtx;

        // set up the parent contexts
        $retval->parentContexts = $retval->contexts;
        unset($retval->parentContexts['autoloaderCtx']);
        unset($retval->parentContexts['globalCtx']);
        unset($retval->parentContexts['namespaceCtx']);

        return $retval;
    }

    /**
     * which namespace are we currently defining things in?
     *
     * @return Contexts\NamespaceContext
     */
    public function getNamespace()
    {
        return $this->contexts['namespaceCtx'] ?? null;
    }

    /**
     * tell us which namespace we're currently in
     *
     * @param Contexts\NamespaceContext $namespaceCtx
     *        the namespace that we're defining things in
     */
    public function withNamespace(Contexts\NamespaceContext $namespaceCtx) : Scope
    {
        $retval = clone $this;
        $retval->contexts['namespaceCtx'] = $namespaceCtx;

        // set up the parent contexts
        $retval->parentContexts = $retval->contexts;
        unset($retval->parentContexts['autoloaderCtx']);
        unset($retval->parentContexts['globalCtx']);

        // all done
        return $retval;
    }

    /**
     * get the method that we're in
     *
     * @return Contexts\MethodContext|null
     */
    public function getMethod()
    {
        return $this->contexts['methodCtx'];
    }

    /**
     * tell us which method we're currently in
     *
     * @param Contexts\MethodContext $methodCtx|null
     *        the method that we're looking at
     */
    public function withMethod(Contexts\MethodContext $methodCtx) : Scope
    {
        $retval = clone $this;
        $retval->contexts['methodCtx'] = $methodCtx;

        // set up the parent contexts
        $retval->parentContexts = $retval->contexts;
        unset($retval->parentContexts['autoloaderCtx']);
        unset($retval->parentContexts['globalCtx']);
        unset($retval->parentContexts['classCtx']);

        return $retval;
    }

    /**
     * which source file are we working through?
     *
     * @return Contexts\SourceFileContext|null
     */
    public function getSourceFile()
    {
        return $this->contexts['sourceFileCtx'] ?? null;
    }

    /**
     * tell us which source file we are currently working through
     *
     * @param Contexts\SourceFileContext $sourceFileCtx
     * @return Scope
     */
    public function withSourceFile(Contexts\SourceFileContext $sourceFileCtx) : Scope
    {
        $retval = clone $this;
        $retval->contexts['sourceFileCtx'] = $sourceFileCtx;

        // set up the parent contexts
        $retval->parentContexts = $retval->contexts;

        return $retval;
    }

    /**
     * get the trait that we're in
     *
     * @return Contexts\TraitContext|null
     */
    public function getTrait()
    {
        return $this->contexts['traitCtx'] ?? null;
    }

    /**
     * tell us which trait we're currently in
     *
     * @param Contexts\TraitContext $traitCtx
     *        the trait that we're looking at
     */
    public function withTrait(Contexts\TraitContext $traitCtx) : Scope
    {
        $retval = clone $this;
        $retval->contexts['traitCtx'] = $traitCtx;

        // set up the parent contexts
        $retval->parentContexts = $retval->contexts;
        unset($retval->parentContexts['autoloaderCtx']);
        unset($retval->parentContexts['globalCtx']);
        unset($retval->parentContexts['namespaceCtx']);

        return $retval;
    }
}