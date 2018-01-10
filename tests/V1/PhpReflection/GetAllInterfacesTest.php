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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllInterfaces;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddInterfacesToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddInterfacesToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllInterfaces
 */
class GetAllInterfacesTest extends TestCase
{
    use AddInterfacesToContainer;

    /**
     * @coversNothing
     */
    public function test_can_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = new GetAllInterfaces;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(GetAllInterfaces::class, $unit);
    }

    /**
     * @covers ::from
     * @covers ::getAllInterfaces
     */
    public function test_returns_empty_array_when_no_interfaces_in_interface_container()
    {
        // ----------------------------------------------------------------
        // setup your test

        $interfaceContainer = new PhpContexts\PhpGlobalContext;
        $unit = new GetAllInterfaces;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = GetAllInterfaces::from($interfaceContainer);
        $actualResult2 = $unit->getAllInterfaces($interfaceContainer);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], $actualResult1);
        $this->assertEquals([], $actualResult2);
    }

    /**
     * @covers ::from
     * @covers ::getAllInterfaces
     */
    public function test_can_get_all_interfaces_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $interfaceContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasInterfaces::check($interfaceContainer));
        $this->addMinimalInterfaces($interfaceContainer);
        $this->assertTrue(PhpReflection\HasInterfaces::check($interfaceContainer));

        $unit = new GetAllInterfaces;

        // ----------------------------------------------------------------
        // perform the change

        $interfaceCtxs1 = GetAllInterfaces::from($interfaceContainer);
        $interfaceCtxs2 = $unit->getAllInterfaces($interfaceContainer);

        // ----------------------------------------------------------------
        // test the results

        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($interfaceCtxs1));
        $this->assertEquals(2, count($interfaceCtxs1));

        // the interface 'FooInterface' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpInterface::class, $interfaceCtxs1['FooInterface']);
        $this->assertEquals('FooInterface', $interfaceCtxs1['FooInterface']->getName());

        // the interface 'BarInterface' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpInterface::class, $interfaceCtxs1['BarInterface']);
        $this->assertEquals('BarInterface', $interfaceCtxs1['BarInterface']->getName());


        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($interfaceCtxs2));
        $this->assertEquals(2, count($interfaceCtxs2));

        // the interface 'FooInterface' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpInterface::class, $interfaceCtxs2['FooInterface']);
        $this->assertEquals('FooInterface', $interfaceCtxs2['FooInterface']->getName());

        // the interface 'BarInterface' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpInterface::class, $interfaceCtxs2['BarInterface']);
        $this->assertEquals('BarInterface', $interfaceCtxs2['BarInterface']->getName());
    }

}