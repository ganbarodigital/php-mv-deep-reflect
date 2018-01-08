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
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddNamespacesToContainer;

require_once(__DIR__ . '/../PhpFixtures/AddNamespacesToContainer.php');

trait PhpNamespaceContainerTests
{
    use AddNamespacesToContainer;

    /**
     * @covers ::__construct
     */
    public function test_is_PhpNamespaceContainer()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpNamespaceContainer::class, $unit);
    }

    // ==================================================================
    //
    // Namespace Container Tests
    //
    // ------------------------------------------------------------------

    /**
     * @covers ::__construct
     */
    public function test_starts_with_no_namespaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(PhpReflection\HasNamespaces::check($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_getNamespaces_returns_empty_array_when_no_namespaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], PhpReflection\GetAllNamespaces::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_getNamespaceNames_returns_empty_array_when_no_namespaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], PhpReflection\GetNamespaceNames::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_if_any_namespaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasNamespaces::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addNamespaces($unit, 'FooBar');

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasNamespaces::check($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_names_of_namespaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->addNamespaces($unit, 'FooBar', 'BarBaz');
        $expectedResult = [ 'FooBar', 'BarBaz' ];

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = PhpReflection\GetNamespaceNames::from($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_for_named_namespace_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->addNamespaces($unit, 'FooBar', 'BarBaz');

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = PhpReflection\HasNamespace::check($unit, 'FooBar');
        $actualResult2 = PhpReflection\HasNamespace::check($unit, 'FooBaz');

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($actualResult1);
        $this->assertFalse($actualResult2);
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_for_named_namespaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->addNamespaces($unit, 'FooBar', 'BarBaz');

        // ----------------------------------------------------------------
        // perform the change

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals(0, PhpReflection\HasNamespacesCalled::check($unit, ['FooBaz']));
        $this->assertEquals(1, PhpReflection\HasNamespacesCalled::check($unit, ['FooBaz', 'FooBar']));
        $this->assertEquals(2, PhpReflection\HasNamespacesCalled::check($unit, ['FooBaz', 'FooBar', 'BarBaz']));
        $this->assertEquals(2, PhpReflection\HasNamespacesCalled::check($unit, ['FooBar', 'BarBaz']));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_named_namespace_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->addNamespaces($unit, 'FooBar');

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = PhpReflection\GetNamespace::from($unit, 'FooBar');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpNamespace::class, $actualResult);
        $this->assertEquals('FooBar', $actualResult->getName());
    }

    /**
     * @covers ::getChildrenByType
     * @expectedException GanbaroDigital\DeepReflection\V1\PhpExceptions\NoSuchNamespace
     */
    public function test_throws_NoSuchNamespace_if_named_namespace_not_found_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // perform the change

        PhpReflection\GetNamespace::from($unit, 'FooBar');

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::getChildrenByType
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage VIVA LA REVOLUTION
     */
    public function test_can_override_default_behaviour_when_named_namespace_not_found_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $onFatal = new OnFatal(function($name) {
            throw new \InvalidArgumentException("VIVA LA REVOLUTION");
        });

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = PhpReflection\GetNamespace::from($unit, 'FooBar', $onFatal);
    }

}