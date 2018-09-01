<?php

/**
 * Copyright (c) 2017-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\Reflection;

use GanbaroDigital\DeepReflection\V1\Contexts;

/**
 * a list of modifiers you can apply to any PHP code block
 */
class ReflectionModifier
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