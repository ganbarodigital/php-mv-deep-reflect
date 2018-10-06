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
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddClassesToContainer;

require_once(__DIR__ . '/../PhpFixtures/AddClassesToContainer.php');

trait PhpClassContainerTests
{
    use AddClassesToContainer;

    /**
     * @covers ::__construct
     */
    public function test_is_PhpClassContainer()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpClassContainer::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_starts_with_no_classes_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(PhpReflection\HasClasses::check($unit));
    }

    /**
     * @covers ::attachChildContext
     */
    public function test_can_add_classes_to_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasClasses::check($unit));

        $expectedClassNames = [ 'FooClass', 'BarClass' ];

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalClasses($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasClasses::check($unit));
        $this->assertEquals($expectedClassNames, PhpReflection\GetClassNames::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_if_any_classes_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasClasses::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalClasses($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasClasses::check($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_names_of_classes_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasClasses::check($unit));

        $expectedClassNames = [ 'FooClass', 'BarClass' ];

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalClasses($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasClasses::check($unit));
        $this->assertEquals($expectedClassNames, PhpReflection\GetClassNames::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_for_named_class_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasClasses::check($unit));
        $this->assertFalse(PhpReflection\HasClassCalled::check('FooClass', $unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalClasses($unit);
        $this->assertTrue(PhpReflection\HasClasses::check($unit));

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasClassCalled::check('FooClass', $unit));
        $this->assertFalse(PhpReflection\HasClassCalled::check('not_a_class', $unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_for_named_classes_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasClasses::check($unit));
        $this->assertFalse(PhpReflection\HasClassCalled::check('FooClass', $unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalClasses($unit);
        $this->assertTrue(PhpReflection\HasClasses::check($unit));

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(PhpReflection\HasClassesCalled::check(['not_a_class'], $unit));
        $this->assertTrue(PhpReflection\HasClassesCalled::check(['FooClass'], $unit));
        $this->assertTrue(PhpReflection\HasClassesCalled::check(['FooClass', 'BarClass'], $unit));
        $this->assertFalse(PhpReflection\HasClassesCalled::check(['FooClass', 'BarClass', 'not_a_class'], $unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_named_class_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasClasses::check($unit));
        $this->addMinimalClasses($unit);
        $this->assertTrue(PhpReflection\HasClasses::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $classCtx = PhpReflection\GetClass::from('FooClass', $unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpClass::class, $classCtx);
        $this->assertEquals('FooClass', $classCtx->getName());
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_all_classes_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasClasses::check($unit));
        $this->addMinimalClasses($unit);
        $this->assertTrue(PhpReflection\HasClasses::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $classCtxs = PhpReflection\GetAllClasses::from($unit);

        // ----------------------------------------------------------------
        // test the results

        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($classCtxs));
        $this->assertEquals(2, count($classCtxs));

        // the class 'FooClass' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpClass::class, $classCtxs['FooClass']);
        $this->assertEquals('FooClass', $classCtxs['FooClass']->getName());

        // the class 'BarClass' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpClass::class, $classCtxs['BarClass']);
        $this->assertEquals('BarClass', $classCtxs['BarClass']->getName());
    }
}