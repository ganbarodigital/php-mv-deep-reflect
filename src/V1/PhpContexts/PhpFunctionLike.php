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

use GanbaroDigital\DeepReflection\V1\PhpScopes\PhpScope;
use GanbaroDigital\MissingBits\TypeInspectors\GetNamespace;
use GanbaroDigital\MissingBits\TypeInspectors\StripNamespace;

/**
 * container for everything in the scope of something that acts like
 * a function or method
 */
class PhpFunctionLike extends PhpSourceCode
{
    /**
     * what is the full name of this function-like thing?
     *
     * @var string
     */
    protected $fqfn;

    /**
     * what's the name of our namespace?
     * @var string
     */
    protected $namespaceName;

    /**
     * what's the name of our function, sans namespace?
     * @var string
     */
    protected $functionName;

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

    public function __construct(PhpScope $scope, bool $isAbstract, string $securityScope, bool $isStatic, string $fqfn, string $returnType = null)
    {
        parent::__construct($scope);

        $this->isAbstract = $isAbstract;
        $this->securityScope = $securityScope;
        $this->isStatic = $isStatic;

        $this->fqfn = $fqfn;
        $this->namespaceName = GetNamespace::from($fqfn);
        $this->functionName = StripNamespace::from($fqfn);

        $this->returnType = $returnType;
    }

    /**
     * what is the name of the context we represent?
     *
     * @return string
     */
    public function getName()
    {
        return $this->fqfn;
    }

    /**
     * what is the name of this function, inside our parent context?
     *
     * @return string
     */
    public function getInContextName()
    {
        return $this->functionName;
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
        return 'function-like';
    }
}
