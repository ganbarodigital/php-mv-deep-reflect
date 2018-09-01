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

namespace GanbaroDigital\DeepReflection\V1\ComposerContexts;

use GanbaroDigital\DeepReflection\V1\Context;
use GanbaroDigital\DeepReflection\V1\Exceptions\UnsupportedContext;
use GanbaroDigital\DeepReflection\V1\PhpContexts;

/**
 * container for everything we learn about a single composer component
 */
class ComposerPackageContext implements Context
{
    /**
     * what is the name of this composer component?
     * @var string
     */
    protected $componentName;

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
     * which namespaces *have* we loaded?
     * @var array
     */
    protected $namespaces = [];

    /**
     * which source files *have* we loaded?
     * @var array
     */
    protected $sourceFiles = [];

    /**
     * where will we be looking for .php and .inc files?
     * @var array
     */
    protected $autoloadClassmaps = [];

    /**
     * which classes have we seen in this component?
     * @var array
     */
    protected $classes = [];

    /**
     * which interfaces have we seen in this component?
     * @var array
     */
    protected $interfaces = [];

    /**
     * which traits have we seen in this component?
     * @var array
     */
    protected $traits = [];

    /**
     * which functions have we seen in this component?
     * @var array
     */
    protected $functions = [];

    public function __construct(string $componentName)
    {
        $this->componentName = $componentName;
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

            case $context instanceof PhpContexts\SourceFileContext:
                $this->sourceFiles[$context->getFilename()] = $context;
                break;

            case $context instanceof PhpContexts\NamespaceContext:
                $namespaceName = $context->getContainingNamespace();
                $this->namespaces[$namespaceName] = $context;
                break;

            case $context instanceof PhpContexts\ClassContext:
                $this->classes[$context->getName()] = $context;
                break;

            case $context instanceof PhpContexts\FunctionContext:
                $this->functions[$context->getName()] = $context;
                break;

            case $context instanceof PhpContexts\InterfaceContext:
                $this->interfaces[$context->getName()] = $context;
                break;

            case $context instanceof PhpContexts\TraitContext:
                $this->traits[$context->getName()] = $context;
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

    public function getAutoloadPsr0() : array
    {
        return $this->autoloadPsr0;
    }

    public function getAutoloadPsr4() : array
    {
        return $this->autoloadPsr4;
    }

    public function getAutoloadFiles() : array
    {
        return $this->autoloadFiles;
    }

    public function getAutoloadClassmaps() : array
    {
        return $this->autoloadClassmaps;
    }

    /**
     * return the name of the composer component
     *
     * @return string
     *         the component name
     */
    public function getComponentName()
    {
        return $this->componentName;
    }

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

    public function getClasses(): array
    {
        return $this->classes;
    }

    public function getInterfaces(): array
    {
        return $this->interfaces;
    }

    public function getTraits(): array
    {
        return $this->traits;
    }

    public function getFunctions(): array
    {
        return $this->functions;
    }
}
