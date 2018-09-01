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

namespace GanbaroDigital\DeepReflection\V1\PhpScopes;

use GanbaroDigital\DeepReflection\V1\ComposerContexts;
use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\Scope;

/**
 * keep track of the current active scope(s)
 */
class PhpScope extends Scope
{
    /**
     * create a new active scope
     */
    public function __construct(PhpContexts\PhpGlobalContext $globalCtx)
    {
        $this->contexts[PhpContexts\PhpGlobalContext::class] = $globalCtx;
    }

    /**
     * get the global context
     *
     * we *always* have a global context
     *
     * @return PhpContexts\PhpGlobalContext
     */
    public function getGlobalContext()
    {
        return $this->getContext(PhpContexts\PhpGlobalContext::class);
    }

    /**
     * get the current ways we can autoload things
     *
     * @return ComposerContexts\AutoloaderContext
     */
    public function getAutoloaderContext()
    {
        return $this->getContext(PhpContexts\PhpAutoloader::class);
    }

    /**
     * get the class that we're in
     *
     * @return PhpContexts\PhpClass|null
     */
    public function getClass()
    {
        return $this->getContext(PhpContexts\PhpClass::class);
    }

    /**
     * get the name of the class that we're in (if any)
     *
     * @return string|null
     */
    public function getClassName()
    {
        return $this->getContextName(PhpContexts\PhpClass::class);
    }

    /**
     * which composer package are we in (if any)?
     *
     * this will be the same value as returned by $this->getComposerProject()
     * *if* we are looking at something inside that project
     *
     * this will be a different value if we are looking at something inside
     * the `vendor` folder
     *
     * @return ComposerContexts\ComposerPackageContext|null
     */
    public function getComposerPackage()
    {
        return $this->getContext(ComposerContexts\ComposerPackageContext::class);
    }

    /**
     * which composer project are we in (if any)?
     *
     * NOTE: if we are part of a composer package in the `vendor` folder,
     * this will return the top-level project, not the package in the `vendor`
     * folder
     *
     * @return ComposerContexts\ComposerProjectContext|null
     */
    public function getComposerProject()
    {
        return $this->getContext(ComposerContexts\ComposerProjectContext::class);
    }

    /**
     * get the function that we're in (if any)
     *
     * @return PhpContexts\PhpFunction|null
     */
    public function getFunction()
    {
        return $this->getContext(PhpContexts\PhpFunction::class);
    }

    /**
     * get the name of the function that we're in (if any)
     *
     * @return string|null
     */
    public function getFunctionName()
    {
        return $this->getContextName(PhpContexts\PhpFunction::class);
    }

    /**
     * get the interface that we're in (if any)
     *
     * @return PhpContexts\PhpInterface|null
     */
    public function getInterface()
    {
        return $this->getContext(PhpContexts\PhpInterface::class);
    }

    /**
     * get the name of the interface that we're in (if any)
     *
     * @return string|null
     */
    public function getInterfaceName()
    {
        return $this->getContextName(PhpContexts\PhpInterface::class);
    }

    /**
     * which namespace are we currently defining things in?
     *
     * if we are *not* in a namespace, we return the global context
     * (which is really just the global namespace)
     *
     * @return PhpContexts\PhpNamespace
     */
    public function getNamespace()
    {
        return $this->contexts[PhpContexts\PhpNamespace::class] ?? $this->contexts[PhpContexts\PhpGlobalContext::class];
    }

    /**
     * what is the name of the namespace that we are currently defining
     * things in?
     *
     * if we are *not* in a namespace, we return '' (the global namespace)
     *
     * @return string
     */
    public function getNamespaceName()
    {
        return $this->getNamespace()->getName();
    }

    /**
     * get the method that we're in (if any)
     *
     * @return PhpContexts\PhpMethod|null
     */
    public function getMethod()
    {
        return $this->getContext(PhpContexts\PhpMethod::class);
    }

    /**
     * get the name of the method that we're in (if any)
     *
     * @return string|null
     */
    public function getMethodName()
    {
        return $this->getContextName(PhpContexts\PhpMethod::class);
    }

    /**
     * which source file are we working through?
     *
     * @return PhpContexts\PhpSourceFile|null
     */
    public function getSourceFile()
    {
        return $this->getContext(PhpContexts\PhpSourceFile::class);
    }

    /**
     * which source file are we working through?
     *
     * @return string|null
     */
    public function getSourceFileName()
    {
        return $this->getContextName(PhpContexts\PhpSourceFile::class);
    }

    /**
     * get the trait that we're in (if any)
     *
     * @return PhpContexts\PhpTrait|null
     */
    public function getTrait()
    {
        return $this->getContext(PhpContexts\PhpTrait::class);
    }

    /**
     * get the name of the trait that we're in (if any)
     *
     * @return string|null
     */
    public function getTraitName()
    {
        return $this->getContextName(PhpContexts\PhpTrait::class);
    }

    public function __toString()
    {
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        exit(1);
    }
}