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

use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpInterfaceContainer;
use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpInterface;
use GanbaroDigital\DeepReflection\V1\PhpExceptions;
use GanbaroDigital\MissingBits\ClassesAndObjects\StatelessClass;

/**
 * get details about an interface, by name
 */
class GetInterface
{
    // we don't want you making objects from this class, sorry!
    use StatelessClass;

    /**
     * get details about an interface, by name
     *
     * @param  string $name
     *         the name of the interface to look for
     * @param  PhpInterfaceContainer $context
     *         the context to extract from
     * @param  callable|null $onFailure
     *         what to do if we don't have any such interface
     *         Params are:
     *         - `$name` - the name of the interface we cannot find
     * @return PhpInterface
     * @throws PhpExceptions\NoSuchInterface
     *         - if we don't have an interface called `$name`, and
     *         - if `$onFailure` is `null`
     */
    public static function from(string $name, PhpInterfaceContainer $context, callable $onFailure = null) : PhpInterface
    {
        // make sure we have a way to fail
        $onFailure = $onFailure ?? function($name) {
            throw new PhpExceptions\NoSuchInterface($name);
        };

        // do we have it?
        $interfaces = GetAllInterfaces::from($context);
        $retval = $interfaces[$name] ?? $onFailure($name);

        // all done
        return $retval;
    }
}
