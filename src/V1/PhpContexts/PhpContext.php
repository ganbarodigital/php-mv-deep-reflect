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
abstract class PhpContext extends Context
{
    // ==================================================================
    //
    // PHP.net Reflection API
    //
    // ------------------------------------------------------------------


    // ==================================================================
    //
    // Deep Reflection API
    //
    // ------------------------------------------------------------------

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
     * what is the name of this context, in the context that it is being
     * used?
     *
     * @return string
     */
    public function getInContextName()
    {
        return $this->getName();
    }

    public function getByNameAndType($name, $contextType)
    {
        $possibleNames = [
            $name
        ];

        $parts = explode("\\", $name);

        $imported = $this->children[NamespacedImportContext::class][$name] ?? null;
        $fullName = $imported ? $imported->getName() : $name;


    }
}
