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
 * @package   DeepReflection/PhpContexts
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\PhpContexts;

use GanbaroDigital\DeepReflection\V1\Exceptions\UnsupportedContext;

/**
 * container for a docblock
 */
class DocblockContext extends CommentContext
{
    /**
     * short description
     *
     * this is normally the first paragraph of the docblock
     *
     * @var string
     */
    protected $summary;

    /**
     * longer description
     *
     * this is normally everything from the second paragraph of the docblock
     * through to the start of the '@' tags
     *
     * @var string
     */
    protected $description;

    /**
     * a list of parameters
     *
     * these are in the order that they are defined in the docblock, which
     * *should* be the same order that the function/method accepts
     *
     * @var array
     */
    protected $params;

    /**
     * the function/method's return type, and any description that was
     * attached to it
     *
     * @var array
     */
    protected $retType;

    /**
     * the variable / property / constant's type
     *
     * @var string|null
     */
    protected $type;

    /**
     * any additional tags that were found in the docblock
     *
     * @var array
     */
    protected $tags;

    /**
     * our constructor
     *
     * @param string $comment
     *        the full text of the docblock
     * @param string $summary
     *        the first paragraph of the docblock
     * @param string $description
     *        the second paragraph onwards of the docblock
     * @param array $params
     *        a list of any param tags found
     * @param array $retType
     *        details of any return type found
     * @param string $type
     *        details of any type hint found
     * @param array $tags
     *        a list of any other docblock tags found
     */
    public function __construct($comment, $summary, $description, array $params, array $retType, string $type = null, array $tags)
    {
        parent::__construct($comment);

        $this->summary = $summary;
        $this->description = $description;
        $this->params = $params;
        $this->retType = $retType;
        $this->type = $type;
        $this->tags = $tags;
    }

    // ==================================================================
    //
    // GET INFORMATION ABOUT THIS CONTEXT
    //
    // ------------------------------------------------------------------

    /**
     * return the first paragraph of the docblock's text
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * return second paragraph onwards of the docblock's text
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * return any param tags found in the docblock
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * return any return tag found in the docblock
     *
     * @return array
     */
    public function getReturnType()
    {
        return $this->retType;
    }

    /**
     * return any other tags found in the docblock
     *
     * @return array
     */
    public function getOtherTags()
    {
        return $this->tags;
    }
}
