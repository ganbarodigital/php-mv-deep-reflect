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

namespace GanbaroDigital\DeepReflection\V1\PhpContexts;

/**
 * container for a docblock
 */
class PhpDocblock extends PhpComment
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

    /**
     * what is the name of the context we represent?
     *
     * @return null
     */
    public function getName()
    {
        return null;
    }

    /**
     * what kind of context are we?
     *
     * this should be human-readable, suitable for putting in error
     * messages as so on
     *
     * @return string
     */
    public function getContextType()
    {
        return 'docblock';
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
