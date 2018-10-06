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
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddInterfacesToContainer;

require_once(__DIR__ . '/../PhpFixtures/AddInterfacesToContainer.php');

trait PhpInterfaceContainerTests
{
    use AddInterfacesToContainer;

    /**
     * @covers ::__construct
     */
    public function test_is_PhpInterfaceContainer()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpInterfaceContainer::class, $unit);
    }


    /**
     * @covers ::__construct
     */
    public function test_starts_with_no_interfaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_GetAllInterfaces_returns_empty_array_when_no_interfaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], PhpReflection\GetAllInterfaces::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_GetInterfaceNames_returns_empty_array_when_no_interfaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], PhpReflection\GetInterfaceNames::from($unit));
    }

    /**
     * @covers ::attachChildContext
     */
    public function test_can_add_interfaces_to_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));

        $expectedInterfaceNames = [ 'FooInterface', 'BarInterface' ];

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalInterfaces($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasInterfaces::check($unit));
        $this->assertEquals($expectedInterfaceNames, PhpReflection\GetInterfaceNames::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_if_any_interfaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalInterfaces($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasInterfaces::check($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_names_of_interfaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));

        $expectedInterfaceNames = [ 'FooInterface', 'BarInterface' ];

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalInterfaces($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasInterfaces::check($unit));
        $this->assertEquals($expectedInterfaceNames, PhpReflection\GetInterfaceNames::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_for_named_interface_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));
        $this->assertFalse(PhpReflection\HasInterfaceCalled::check('FooInterface', $unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalInterfaces($unit);
        $this->assertTrue(PhpReflection\HasInterfaces::check($unit));

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasInterfaceCalled::check('FooInterface', $unit));
        $this->assertFalse(PhpReflection\HasInterfaceCalled::check('not_an_interface', $unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_for_named_interfaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));
        $this->assertFalse(PhpReflection\HasInterfaceCalled::check('FooInterface', $unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalInterfaces($unit);
        $this->assertTrue(PhpReflection\HasInterfaces::check($unit));

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals(0, PhpReflection\HasInterfacesCalled::check(['not_an_interface'], $unit));
        $this->assertEquals(1, PhpReflection\HasInterfacesCalled::check(['FooInterface'], $unit));
        $this->assertEquals(2, PhpReflection\HasInterfacesCalled::check(['FooInterface', 'BarInterface'], $unit));
        $this->assertEquals(2, PhpReflection\HasInterfacesCalled::check(['FooInterface', 'BarInterface', 'not_an_interface'], $unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_named_interface_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));
        $this->addMinimalInterfaces($unit);
        $this->assertTrue(PhpReflection\HasInterfaces::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $interfaceCtx = PhpReflection\GetInterface::from('FooInterface', $unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpInterface::class, $interfaceCtx);
        $this->assertEquals('FooInterface', $interfaceCtx->getName());
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_all_interfaces_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));
        $this->addMinimalInterfaces($unit);
        $this->assertTrue(PhpReflection\HasInterfaces::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $interfaceCtxs = PhpReflection\GetAllInterfaces::from($unit);

        // ----------------------------------------------------------------
        // test the results

        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($interfaceCtxs));
        $this->assertEquals(2, count($interfaceCtxs));

        // the interface 'FooInterface' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpInterface::class, $interfaceCtxs['FooInterface']);
        $this->assertEquals('FooInterface', $interfaceCtxs['FooInterface']->getName());

        // the interface 'BarInterface' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpInterface::class, $interfaceCtxs['BarInterface']);
        $this->assertEquals('BarInterface', $interfaceCtxs['BarInterface']->getName());
    }

    /**
     * @covers ::getChildrenByType
     * @expectedException GanbaroDigital\DeepReflection\V1\PhpExceptions\NoSuchInterface
     */
    public function test_throws_NoSuchInterface_when_named_interface_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));
        $this->addMinimalInterfaces($unit);
        $this->assertTrue(PhpReflection\HasInterfaces::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $functionCtx = PhpReflection\GetInterface::from('not_an_interface', $unit);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::getChildrenByType
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage VIVA LA REVOLUTION
     */
    public function test_can_override_failure_action_when_named_interface_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));
        $this->addMinimalInterfaces($unit);
        $this->assertTrue(PhpReflection\HasInterfaces::check($unit));

        $onFatal = new OnFatal(function($name) {
            throw new \InvalidArgumentException("VIVA LA REVOLUTION");
        });

        // ----------------------------------------------------------------
        // perform the change

        $interfaceCtx = PhpReflection\GetInterface::from('not_a_interface', $unit, $onFatal);

    }

}