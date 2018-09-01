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

use GanbaroDigital\DeepReflection\V1\Context;
use GanbaroDigital\DeepReflection\V1\Exceptions\UnsupportedContext;

/**
 * container for describing a constant on a class-like context
 */
class PhpClassLikeConstant extends PhpSourceCode
{
    /**
     * what is the name of this property?
     *
     * @var string
     */
    protected $name;

    /**
     * what is our default value?
     *
     * @var string|null
     */
    protected $defaultValue;

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

    public function __construct(string $securityScope, string $name, string $defaultValue = null)
    {
        $this->securityScope = $securityScope;
        $this->name = $name;
        $this->defaultValue = $defaultValue;
    }

    /**
     * what is the name of the context we represent?
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
        return 'class-like constant';
    }

    // ==================================================================
    //
    // based on PHP.net Reflection API
    //
    // ------------------------------------------------------------------

    /**
     * which class was this constant defined in?
     *
     * @return ReflectionClass
     */
    public function getDeclaringClass()
    {
        return $this->children[ParentClassReference::class][0];
    }

    /**
     * what is this constant's value?
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->defaultValue;
    }

    /**
     * is this class constant marked as `private`?
     *
     * @return bool
     *         - `true` if this constant is marked as `private`
     *         - `false` otherwise
     */
    public function isPrivate()
    {

    }

    /**
     * is this class constant marked as `protected`?
     *
     * @return bool
     *         - `true` if this constant is marked as `protected`
     *         - `false` otherwise
     */
    public function isProtected()
    {

    }

    /**
     * is this class constant marked as `public`?
     *
     * @return boolean [description]
     */
    public function isPublic()
    {

    }

    /**
     * returns a representation of this constant
     *
     * @return string
     */
    public function __toString()
    {

    }

    // ==================================================================
    //
    // DeepReflection API
    //
    // ------------------------------------------------------------------

}
