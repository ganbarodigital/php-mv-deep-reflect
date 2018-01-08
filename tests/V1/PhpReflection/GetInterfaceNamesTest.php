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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetInterfaceNames;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddInterfacesToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddInterfacesToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetInterfaceNames
 */
class GetInterfaceNamesTest extends TestCase
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

        $unit = new GetInterfaceNames;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(GetInterfaceNames::class, $unit);
    }

    /**
     * @covers ::from
     * @covers ::__invoke
     * @covers ::getInterfaceNames
     */
    public function test_returns_empty_array_when_no_interfaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $interfaceContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasInterfaces::check($interfaceContainer));

        $unit = new GetInterfaceNames;

        // ----------------------------------------------------------------
        // perform the change


        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], GetInterfaceNames::from($interfaceContainer));
        $this->assertEquals([], $unit($interfaceContainer));
        $this->assertEquals([], $unit->getInterfaceNames($interfaceContainer));
    }

    /**
     * @covers ::from
     * @covers ::__invoke
     * @covers ::getInterfaceNames
     */
    public function test_can_get_list_of_interface_names_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $interfaceContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasInterfaces::check($interfaceContainer));
        $this->addMinimalInterfaces($interfaceContainer);
        $this->assertTrue(PhpReflection\HasInterfaces::check($interfaceContainer));

        $unit = new GetInterfaceNames;

        $expectedNames = [ 'FooInterface', 'BarInterface' ];

        // ----------------------------------------------------------------
        // perform the change


        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedNames, GetInterfaceNames::from($interfaceContainer));
        $this->assertEquals($expectedNames, $unit($interfaceContainer));
        $this->assertEquals($expectedNames, $unit->getInterfaceNames($interfaceContainer));
    }
}