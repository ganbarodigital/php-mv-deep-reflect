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
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddTraitsToContainer;

require_once(__DIR__ . '/../PhpFixtures/AddTraitsToContainer.php');

trait PhpTraitContainerTests
{
    use AddTraitsToContainer;

    /**
     * @covers ::__construct
     */
    public function test_is_PhpTraitContainer()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpTraitContainer::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_starts_with_no_traits_in_container()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(PhpReflection\HasTraits::check($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_GetTraits_returns_empty_array_when_no_traits_in_container()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], PhpReflection\GetAllTraits::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_GetTraitNames_returns_empty_array_when_no_traits_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], PhpReflection\GetTraitNames::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_add_traits_to_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasTraits::check($unit));

        $expectedTraitNames = [ 'FooTrait', 'BarTrait' ];

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalTraits($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasTraits::check($unit));
        $this->assertEquals($expectedTraitNames, PhpReflection\GetTraitNames::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_if_any_traits_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasTraits::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalTraits($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasTraits::check($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_names_of_traits_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasTraits::check($unit));

        $expectedTraitNames = [ 'FooTrait', 'BarTrait' ];

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalTraits($unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasTraits::check($unit));
        $this->assertEquals($expectedTraitNames, PhpReflection\GetTraitNames::from($unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_for_named_trait_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasTraits::check($unit));
        $this->assertFalse(PhpReflection\HasTraitCalled::check('FooTrait', $unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalTraits($unit);
        $this->assertTrue(PhpReflection\HasTraits::check($unit));

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(PhpReflection\HasTraitCalled::check('FooTrait', $unit));
        $this->assertFalse(PhpReflection\HasTraitCalled::check('not_a_trait', $unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_check_for_named_traits_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasTraits::check($unit));
        $this->assertFalse(PhpReflection\HasTraitCalled::check('FooTrait', $unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalTraits($unit);
        $this->assertTrue(PhpReflection\HasTraits::check($unit));

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(PhpReflection\HasTraitsCalled::check(['not_a_trait'], $unit));
        $this->assertTrue(PhpReflection\HasTraitsCalled::check(['FooTrait'], $unit));
        $this->assertTrue(PhpReflection\HasTraitsCalled::check(['FooTrait', 'BarTrait'], $unit));
        $this->assertFalse(PhpReflection\HasTraitsCalled::check(['FooTrait', 'BarTrait', 'not_a_trait'], $unit));
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_named_trait_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasTraits::check($unit));
        $this->addMinimalTraits($unit);
        $this->assertTrue(PhpReflection\HasTraits::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $traitCtx = PhpReflection\GetTrait::from('FooTrait', $unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpTrait::class, $traitCtx);
        $this->assertEquals('FooTrait', $traitCtx->getName());
    }

    /**
     * @covers ::getChildrenByType
     */
    public function test_can_get_all_traits_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasTraits::check($unit));
        $this->addMinimalTraits($unit);
        $this->assertTrue(PhpReflection\HasTraits::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $traitCtxs = PhpReflection\GetAllTraits::from($unit);

        // ----------------------------------------------------------------
        // test the results

        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($traitCtxs));
        $this->assertEquals(2, count($traitCtxs));

        // the trait 'FooTrait' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpTrait::class, $traitCtxs['FooTrait']);
        $this->assertEquals('FooTrait', $traitCtxs['FooTrait']->getName());

        // the trait 'BarTrait' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpTrait::class, $traitCtxs['BarTrait']);
        $this->assertEquals('BarTrait', $traitCtxs['BarTrait']->getName());
    }

    /**
     * @covers ::getChildrenByType
     * @expectedException GanbaroDigital\DeepReflection\V1\PhpExceptions\NoSuchTrait
     */
    public function test_throws_NoSuchTrait_when_named_trait_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasTraits::check($unit));
        $this->addMinimalTraits($unit);
        $this->assertTrue(PhpReflection\HasTraits::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $functionCtx = PhpReflection\GetTrait::from('not_a_trait', $unit);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::getChildrenByType
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage VIVA LA REVOLUTION
     */
    public function test_can_override_failure_action_when_named_trait_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasTraits::check($unit));
        $this->addMinimalTraits($unit);
        $this->assertTrue(PhpReflection\HasTraits::check($unit));

        $onFatal = new OnFatal(function($name) {
            throw new \InvalidArgumentException("VIVA LA REVOLUTION");
        });

        // ----------------------------------------------------------------
        // perform the change

        $traitCtx = PhpReflection\GetTrait::from('not_a_trait', $unit, $onFatal);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals("not_a_trait not found", $traitCtx);
    }


}