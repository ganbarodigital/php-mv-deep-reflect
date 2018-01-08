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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetFunction;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddFunctionsToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddFunctionsToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetFunction
 */
class GetFunctionTest extends TestCase
{
    use AddFunctionsToContainer;

    /**
     * @coversNothing
     */
    public function test_can_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = new GetFunction;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(GetFunction::class, $unit);
    }

    /**
     * @covers ::from
     */
    public function test_can_get_named_function_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $funcContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasFunctions::check($funcContainer));
        $this->addMinimalFunctions($funcContainer);
        $this->assertTrue(PhpReflection\HasFunctions::check($funcContainer));

        $unit = new GetFunction;

        // ----------------------------------------------------------------
        // perform the change

        $funcCtx1 = GetFunction::from($funcContainer, 'foo');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpFunction::class, $funcCtx1);
        $this->assertEquals('foo', $funcCtx1->getName());
    }

    /**
     * @covers ::from
     * @expectedException GanbaroDigital\DeepReflection\V1\PhpExceptions\NoSuchFunction
     */
    public function test_throws_NoSuchFunction_when_named_function_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $funcContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasFunctions::check($funcContainer));
        $this->addMinimalFunctions($funcContainer);
        $this->assertTrue(PhpReflection\HasFunctions::check($funcContainer));

        $unit = new GetFunction;

        // ----------------------------------------------------------------
        // perform the change

        $functionCtx = GetFunction::from($funcContainer, 'not_a_function');

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::from
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage VIVA LA REVOLUTION
     */
    public function test_can_override_failure_action_when_named_function_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $funcContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasFunctions::check($funcContainer));
        $this->addMinimalFunctions($funcContainer);
        $this->assertTrue(PhpReflection\HasFunctions::check($funcContainer));

        $unit = new GetFunction;

        $onFatal = new OnFatal(function($name) {
            throw new \InvalidArgumentException("VIVA LA REVOLUTION");
        });

        // ----------------------------------------------------------------
        // perform the change

        $funcCtx = GetFunction::from($funcContainer, 'not_a_function', $onFatal);
    }

}