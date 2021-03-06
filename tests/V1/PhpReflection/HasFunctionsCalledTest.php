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

namespace GanbaroDigitalTest\DeepReflection\V1\PhpReflection;

use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\PhpReflection;
use GanbaroDigital\DeepReflection\V1\PhpReflection\HasFunctionsCalled;
use GanbaroDigital\MissingBits\Checks\Check;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddFunctionsToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddFunctionsToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\HasFunctionsCalled
 */
class HasFunctionsCalledTest extends TestCase
{
    use AddFunctionsToContainer;

    /**
     * @covers ::__construct
     * @expectedException Error
     */
    public function test_cannot_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new HasFunctionsCalled();

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::check
     */
    public function test_returns_true_if_named_functions_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $context = new PhpContexts\PhpGlobalContext;
        $this->addMinimalFunctions($context);

        // ----------------------------------------------------------------
        // perform the change

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(HasFunctionsCalled::check(['foo'], $context));
        $this->assertTrue(HasFunctionsCalled::check(['bar'], $context));
        $this->assertTrue(HasFunctionsCalled::check(['foo', 'bar'], $context));
    }

    // /**
    //  * @covers ::check
    //  */
    // public function test_returns_false_otherwise()
    // {
    //     // ----------------------------------------------------------------
    //     // setup your test

    //     $context = new PhpContexts\PhpGlobalContext;
    //     $this->addMinimalClasses($context);

    //     // ----------------------------------------------------------------
    //     // perform the change

    //     // ----------------------------------------------------------------
    //     // test the results

    //     // prove that FooClass is in there
    //     $this->assertTrue(HasClassesCalled::check(['FooClass'], $context));

    //     $this->assertFalse(HasClassesCalled::check(['not_a_class'], $context));
    //     $this->assertFalse(HasClassesCalled::check(['FooClass', 'not_a_class'], $context));
    // }

}