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
 * @package   DeepReflection/ComposerContexts
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\ComposerContexts;

use GanbaroDigital\DeepReflection\V1\Context;
use GanbaroDigital\DeepReflection\V1\Exceptions\UnsupportedContext;
use GanbaroDigital\DeepReflection\V1\PhpContexts;

/**
 * container for every autoloader instruction we come across
 */
class AutoloaderContext implements Context
{
    /**
     * what PSR0 autoloading do we need to do?
     * @var array
     */
    protected $autoloadPsr0 = [];

    /**
     * what PSR4 autoloading do we need to do?
     * @var array
     */
    protected $autoloadPsr4 = [];

    /**
     * which files would we be autoloading?
     * @var array
     */
    protected $autoloadFiles = [];

    /**
     * where will we be looking for .php and .inc files?
     * @var array
     */
    protected $autoloadClassmaps = [];

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
            case $context instanceof AutoloadPsr0Context:
                $this->autoloadPsr0[$context->getAutoloadNamespace()][] = $context;
                break;

            case $context instanceof AutoloadPsr4Context:
                $this->autoloadPsr4[$context->getAutoloadNamespace()][] = $context;
                break;

            case $context instanceof AutoloadFileContext:
                $this->autoloadFiles[] = $context;
                break;

            case $context instanceof AutoloadClassmapContext:
                $this->autoloadClassmaps[] = $context;
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
            // do nothing
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
        return null;
    }

    /**
     * return the docblock for a context - if there is one!
     *
     * @return DocblockContext|null
     */
    public function getDocblock()
    {
        return null;
    }

    /**
     * return the source file where we were defined
     *
     * @return SourceFileContext
     */
    public function getSourceFile() : PhpContexts\SourceFileContext
    {
        return $this->definedIn;
    }
}