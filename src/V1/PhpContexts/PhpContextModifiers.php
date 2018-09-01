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
 * a list of modifiers you can apply to any PHP code block
 */
class PhpContextModifiers
{
    // ==================================================================
    //
    // Modifiers that can be applied to PHP code
    //
    // ------------------------------------------------------------------

    const NO_MODIFIERS = 0;
    const IS_PUBLIC = 1;
    const IS_PROTECTED = 2;
    const IS_PRIVATE = 2^2;
    const IS_FINAL = 2^3;
    const IS_ABSTRACT = 2^4;
    const IS_STATIC = 2^5;

    // ==================================================================
    //
    // Modifiers that are derived from understanding the PHP code
    //
    // ------------------------------------------------------------------

    const IS_IMPLICIT_ABSTRACT = 2^15;
    const IS_EXPLICIT_ABSTRACT = 2^14;
    const IS_EXPLICIT_PUBLIC = 2^13;
    const IS_IMPLICIT_PUBLIC = 2^12;

    // ==================================================================
    //
    // Additional modifiers to make filtering lists a bit easier
    //
    // ------------------------------------------------------------------

    const NOT_STATIC = 2 ^ 16;
    const NOT_INSTANCE = 2 ^17;
    const NOT_ABSTRACT = 2 ^ 18;
    const IS_INHERITED = 2 ^ 19;
    const NOT_INHERITED = 2 ^ 20;
    const FROM_TRAIT = 2 ^ 21;
    const NOT_FROM_TRAIT = 2 ^ 22;
    const FROM_INTERFACE = 2 ^ 23;
    const NOT_FROM_INTERFACE = 2 ^ 24;
    const FROM_PARENT = 2 ^ 25;
    const NOT_FROM_PARENT = 2 ^ 26;
}