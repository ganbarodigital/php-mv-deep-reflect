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
use GanbaroDigital\MissingBits\TypeInspectors\GetNamespace;
use GanbaroDigital\MissingBits\TypeInspectors\StripNamespace;

/**
 * container for everything that is like a class
 */
class ClassLikeContext implements Context
{
    /**
     * what is the full name of this class?
     *
     * @var string
     */
    protected $fqcn;

    /**
     * what's the name of our namespace?
     * @var string
     */
    protected $namespaceName;

    /**
     * what's the name of our class, sans namespace?
     * @var string
     */
    protected $classname;

    /**
     * what is our raw, unparsed docblock?
     * @var CommentContext
     */
    protected $comment;

    /**
     * which file are we defined in?
     *
     * @var SourceFileContext
     */
    protected $definedIn;

    /**
     * what methods (if any) do we have?
     *
     * @var array
     */
    protected $methods = [];

    /**
     * what properties (if any) do we have?
     *
     * @var array
     */
    protected $properties = [];

    /**
     * what constants (if any) do we have?
     *
     * @var array
     */
    protected $constants = [];

    /**
     * our constructor
     *
     * @param string $fqcn
     *        the fully-qualified class name
     */
    public function __construct(string $fqcn)
    {
        $this->fqcn = $fqcn;
        $this->namespaceName = GetNamespace::from($fqcn);
        $this->classname = StripNamespace::from($fqcn);
    }

    /**
     * add something to our scope
     *
     * @param  Context $context
     *         the context that we want to add
     * @return void
     */
    public function attachChildContext(Context $context)
    {
        // what kind of context do we have?
        switch (true) {
            case $context instanceof CommentContext:
                $this->comment = $context;
                break;

            case $context instanceof ClassLikeConstantContext:
                $this->constants[$context->getName()] = $context;
                break;

            case $context instanceof MethodContext:
                $this->methods[$context->getName()] = $context;
                break;

            case $context instanceof PropertyContext:
                $this->properties[$context->getName()] = $context;
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
        switch (true) {
            case $context instanceof GlobalContext:
                // we are a global class, with no namespace
                break;

            case $context instanceof NamespaceContext:
                // we are a namespaced class
                break;

            case $context instanceof SourceFileContext:
                // which file were we defined in?
                $this->definedIn = $context;
                break;

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
    public function getContainingNamespace() : string
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
     * return the full name of this class
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->fqcn;
    }

    /**
     * return the namespace that this class is part of
     *
     * if there is no namespace, will return an empty string
     *
     * @return string
     */
    public function getNamespaceName() : string
    {
        return $this->namespaceName;
    }

    /**
     * return the name of the class, minus its namespace
     *
     * @return string
     */
    public function getShortName() : string
    {
        return $this->classname;
    }

    /**
     * return the source file where we were defined
     *
     * @return SourceFileContext
     */
    public function getSourceFile() : SourceFileContext
    {
        return $this->definedIn;
    }
}
