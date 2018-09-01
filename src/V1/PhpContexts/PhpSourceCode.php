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
use GanbaroDigital\DeepReflection\V1\PhpScopes;

/**
 * represents information about PHP code
 */
abstract class PhpSourceCode extends PhpContext
{
    // ==================================================================
    //
    // PHP.net Reflection API
    //
    // ------------------------------------------------------------------

    /**
     * get the docblock(if we have one)
     *
     * @return string|false
     */
    public function getDocComment()
    {
        return (string)$this->children[DocblockContext::class][0] ?? '';
    }

    /**
     * return the access modifiers for this class constant
     *
     * @return int
     */
    public function getModifiers()
    {

    }



    // ==================================================================
    //
    // Deep Reflection API
    //
    // ------------------------------------------------------------------

        /**
     * get the docblock for a class
     *
     * @return ReflectionDocBlock|null
     */
    public function getDocblock()
    {
        return $this->children[DocblockContext::class][0] ?? null;
    }

    /**
     * which composer package defines this method?
     *
     * @return ReflectionComposerPackage|null
     */
    public function getComposerProject()
    {
        return $this->scope->getComposerProject();
    }

    /**
     * which composer project defines this method?
     *
     * @return string|false
     */
    public function getComposerProjectName()
    {
        return $this->scope->getComposerProjectName();
    }

    /**
     * return the PHP namespace for this context
     *
     * @return string
     *         - string is empty if this is part of the global scope
     */
    public function getContainingNamespaceName()
    {
        return $this->scope->getNamespace()->getName();
    }

    /**
     * return the source file where we were defined
     *
     * @return SourceFileContext|null
     */
    public function getSourceFile()
    {
        return $this->scope->getSourceFile();
    }

    /**
     * return the name of our source file where we were defined
     *
     * @return string|null
     */
    public function getSourceFileName()
    {
        return $this->scope->getSourceFileName();
    }
}
