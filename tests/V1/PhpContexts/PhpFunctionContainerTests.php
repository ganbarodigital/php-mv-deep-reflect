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

namespace GanbaroDigitalTest\DeepReflection\V1\PhpContexts;

use GanbaroDigital\DeepReflection\V1\Context;
use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\PhpReflection;
use GanbaroDigital\DeepReflection\V1\PhpReflectors;
use GanbaroDigital\DeepReflection\V1\PhpScopes;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddFunctionsToContainer;

require_once(__DIR__ . '/../PhpFixtures/AddFunctionsToContainer.php');

trait PhpFunctionContainerTests
{
    use AddFunctionsToContainer;

    /**
     * @covers ::__construct
     */
    public function test_is_PhpFunctionContainer()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpFunctionContainer::class, $unit);
    }

    /**
     * @covers ::__construct
     * @covers ::getChildrenByType
     */
    public function test_starts_with_no_functions()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(PhpReflection\HasFunctions::check($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_GetAllFunctions_returns_empty_array_when_no_functions_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], PhpReflection\GetAllFunctions::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_GetFunctionNames_returns_empty_array_when_no_functions_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], PhpReflection\GetFunctionNames::from($unit));
    }

    /**
     * @covers ::attachChildContext
     */
    public function test_can_add_functions_to_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));

        $expectedFunctionNames = [ 'foo', 'bar' ];

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalFunctions($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasFunctions::check($unit));
        $this->assertEquals($expectedFunctionNames, PhpReflection\GetFunctionNames::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_if_any_functions_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalFunctions($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasFunctions::check($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_names_of_functions_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));

        $expectedFunctionNames = [ 'foo', 'bar' ];

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalFunctions($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasFunctions::check($unit));
        $this->assertEquals($expectedFunctionNames, PhpReflection\GetFunctionNames::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_for_named_function_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));
        $this->assertFalse(PhpReflection\HasFunctionCalled::check('foo', $unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalFunctions($unit);
        $this->assertTrue(PhpReflection\HasFunctions::check($unit));

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasFunctionCalled::check('foo', $unit));
        $this->assertFalse(PhpReflection\HasFunctionCalled::check('not_a_function', $unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_for_named_functions_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));
        $this->assertFalse(PhpReflection\HasFunctionCalled::check('foo', $unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalFunctions($unit);
        $this->assertTrue(PhpReflection\HasFunctions::check($unit));

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals(0, PhpReflection\HasFunctionsCalled::check(['not_a_function'], $unit));
        $this->assertEquals(1, PhpReflection\HasFunctionsCalled::check(['foo'], $unit));
        $this->assertEquals(2, PhpReflection\HasFunctionsCalled::check(['foo', 'bar'], $unit));
        $this->assertEquals(2, PhpReflection\HasFunctionsCalled::check(['foo', 'bar', 'not_a_function'], $unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_named_function_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));
        $this->addMinimalFunctions($unit);
        $this->assertTrue(PhpReflection\HasFunctions::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $functionCtx = PhpReflection\GetFunction::from('foo', $unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpFunction::class, $functionCtx);
        $this->assertEquals('foo', $functionCtx->getName());
        $this->assertEquals('function', $functionCtx->getContextType());
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_all_functions_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));
        $this->addMinimalFunctions($unit);
        $this->assertTrue(PhpReflection\HasFunctions::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $functionCtxs = PhpReflection\GetAllFunctions::from($unit);

        // ----------------------------------------------------------------
        // test the results

        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($functionCtxs));
        $this->assertEquals(2, count($functionCtxs));

        // the function 'foo' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpFunction::class, $functionCtxs['foo']);
        $this->assertEquals('foo', $functionCtxs['foo']->getName());
        $this->assertEquals('function', $functionCtxs['foo']->getContextType());

        // the function 'bar' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpFunction::class, $functionCtxs['bar']);
        $this->assertEquals('bar', $functionCtxs['bar']->getName());
        $this->assertEquals('function', $functionCtxs['bar']->getContextType());
    }

    /**
     * @covers ::getChildrenByType
     * @expectedException GanbaroDigital\DeepReflection\V1\PhpExceptions\NoSuchFunction
     */
    public function test_throws_NoSuchFunction_when_named_function_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));
        $this->addMinimalFunctions($unit);
        $this->assertTrue(PhpReflection\HasFunctions::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $functionCtx = PhpReflection\GetFunction::from('not_a_function', $unit);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::getChildrenByType
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage VIVA LA REVOLUTION
     */
    public function test_can_override_failure_action_when_named_function_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));
        $this->addMinimalFunctions($unit);
        $this->assertTrue(PhpReflection\HasFunctions::check($unit));

        $onFatal = new OnFatal(function($name) {
            throw new \InvalidArgumentException("VIVA LA REVOLUTION");
        });

        // ----------------------------------------------------------------
        // perform the change

        $functionCtx = PhpReflection\GetFunction::from('not_a_function', $unit, $onFatal);
    }
}