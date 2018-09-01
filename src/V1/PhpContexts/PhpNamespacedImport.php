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

/**
 * container for something imported via a namespace
 */
class PhpNamespacedImport extends PhpSourceCode
{
    /**
     * has this been given an alias?
     *
     * @var string|null
     */
    protected $alias;

    /**
     * what is the name that has been imported?
     *
     * @var string
     */
    protected $importedNamespaceName;

    /**
     * what is our name in our parent context?
     * @var string
     */
    protected $contextName;

    public function __construct(PhpScope $scope, string $name, string $alias = null)
    {
        parent::__construct($scope);

        $this->name = $name;
        $this->alias = $alias;

        // what is our shortname?
        if ($this->alias) {
            $this->shortName = $alias;
        }
        else {
            $parts = explode('\\', $name);
            $this->shortName = end($parts);
        }
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
        return 'imported namespace';
    }

    /**
     * what is the name of this import (as meant to be used in the code)?
     *
     * @return string
     */
    public function getInContextName()
    {
        return $this->shortName;
    }
}
