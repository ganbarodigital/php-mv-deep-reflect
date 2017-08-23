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
 * container for everything in the scope of something that acts like
 * a function or method
 */
class FunctionLikeContext implements Context
{
    /**
     * what is the name of this method?
     *
     * @var string
     */
    protected $name;

    /**
     * what parameters do we accept (if any)?
     * @var array
     */
    protected $params = [];

    /**
     * what is our return type?
     *
     * this holds whatever value you specify if you're using PHP-7.x
     * type declarations
     *
     * for the hint in the docblock, look elsewhere!
     *
     * @var string|null
     */
    protected $returnType;

    /**
     * are we an abstract function-like thing?
     * @var bool
     */
    protected $isAbstract;

    /**
     * are we a static function-like thing?
     * @var bool
     */
    protected $isStatic;

    /**
     * are we public, private, protected, or <empty string>?
     * @var string
     */
    protected $securityScope;

    /**
     * which file are we defined in?
     *
     * @var SourceFileContext
     */
    protected $definedIn;

    /**
     * what is our raw, unparsed docblock?
     * @var CommentContext
     */
    protected $comment;

    /**
     * which class are we part of?
     *
     * @var ClassLikeContext
     */
    protected $parentClass;

    /**
     * what does our docblock say about our params (if anything)?
     *
     * @var array
     */
    protected $docBlockParams = [];

    /**
     * what does our docblock say about our return type (if anything)?
     *
     * @var array
     */
    protected $docBlockReturnType = [];

    public function __construct(bool $isAbstract, string $securityScope, bool $isStatic, string $name, string $returnType = null)
    {
        $this->isAbstract = $isAbstract;
        $this->securityScope = $securityScope;
        $this->isStatic = $isStatic;
        $this->name = $name;
        $this->returnType = $returnType;
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
        switch(true) {
            case $context instanceof DocblockContext:
                $this->docBlockParams = $context->getParams();
                $this->docBlockReturnType = $context->getReturnType();
                // deliberately fall through
            case $context instanceof CommentContext:
                $this->comment = $context;
                break;

            case $context instanceof FunctionLikeParameterContext:
                $this->params[$context->getName()] = $context;
                break;
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
            case $context instanceof SourceFileContext:
                // which file were we defined in?
                $this->definedIn = $context;
                $context->attachChildContext($this);
                break;
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
     * what is this method called?
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
