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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllTraits;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddTraitsToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddTraitsToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllTraits
 */
class GetAllTraitsTest extends TestCase
{
    use AddTraitsToContainer;

    /**
     * @coversNothing
     */
    public function test_can_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = new GetAllTraits;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(GetAllTraits::class, $unit);
    }

    /**
     * @covers ::from
     * @covers ::__invoke
     * @covers ::getAllTraits
     */
    public function test_returns_empty_array_when_no_traits_in_trait_container()
    {
        // ----------------------------------------------------------------
        // setup your test

        $traitContainer = new PhpContexts\PhpGlobalContext;
        $unit = new GetAllTraits;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = GetAllTraits::from($traitContainer);
        $actualResult2 = $unit($traitContainer);
        $actualResult3 = $unit->getAllTraits($traitContainer);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], $actualResult1);
        $this->assertEquals([], $actualResult2);
        $this->assertEquals([], $actualResult3);
    }

    /**
     * @covers ::from
     * @covers ::__invoke
     * @covers ::getAllTraits
     */
    public function test_can_get_all_traits_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $traitContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasTraits::check($traitContainer));
        $this->addMinimalTraits($traitContainer);
        $this->assertTrue(PhpReflection\HasTraits::check($traitContainer));

        $unit = new GetAllTraits;

        // ----------------------------------------------------------------
        // perform the change

        $traitCtxs1 = GetAllTraits::from($traitContainer);
        $traitCtxs2 = $unit($traitContainer);
        $traitCtxs3 = $unit->getAllTraits($traitContainer);

        // ----------------------------------------------------------------
        // test the results

        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($traitCtxs1));
        $this->assertEquals(2, count($traitCtxs1));

        // the trait 'FooTrait' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpTrait::class, $traitCtxs1['FooTrait']);
        $this->assertEquals('FooTrait', $traitCtxs1['FooTrait']->getName());

        // the trait 'BarTrait' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpTrait::class, $traitCtxs1['BarTrait']);
        $this->assertEquals('BarTrait', $traitCtxs1['BarTrait']->getName());


        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($traitCtxs2));
        $this->assertEquals(2, count($traitCtxs2));

        // the trait 'FooTrait' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpTrait::class, $traitCtxs2['FooTrait']);
        $this->assertEquals('FooTrait', $traitCtxs2['FooTrait']->getName());

        // the trait 'BarTrait' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpTrait::class, $traitCtxs2['BarTrait']);
        $this->assertEquals('BarTrait', $traitCtxs2['BarTrait']->getName());


        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($traitCtxs3));
        $this->assertEquals(2, count($traitCtxs3));

        // the trait 'FooTrait' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpTrait::class, $traitCtxs3['FooTrait']);
        $this->assertEquals('FooTrait', $traitCtxs3['FooTrait']->getName());

        // the trait 'BarTrait' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpTrait::class, $traitCtxs3['BarTrait']);
        $this->assertEquals('BarTrait', $traitCtxs3['BarTrait']->getName());
    }

}