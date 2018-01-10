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

namespace GanbaroDigital\DeepReflection\V1\PhpReflection;

use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpInterface;
use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpInterfaceContainer;

/**
 * get a list of all interfaces from a given context
 */
class GetAllInterfaces
{
    /**
     * get a list of all interfaces from a given context
     *
     * @param  PhpInterfaceContainer $context
     *         the context to extract from
     * @return PhpInterface[]
     */
    public static function from(PhpInterfaceContainer $context) : array
    {
        return $context->getChildrenByType(PhpInterface::class);
    }

    /**
     * get a list of all interfaces from a given context
     *
     * @param  PhpInterfaceContainer $context
     *         the context to extract from
     * @return PhpInterface[]
     */
    public function getAllInterfaces(PhpInterfaceContainer $context) : array
    {
        return $context->getChildrenByType(PhpInterface::class);
    }
}
