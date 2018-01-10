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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllClasses;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddClassesToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddClassesToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllClasses
 */
class GetAllClassesTest extends TestCase
{
    use AddClassesToContainer;

    /**
     * @coversNothing
     */
    public function test_can_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = new GetAllClasses;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(GetAllClasses::class, $unit);
    }

    /**
     * @covers ::from
     * @covers ::getAllClasses
     */
    public function test_returns_empty_array_when_no_classes_in_class_container()
    {
        // ----------------------------------------------------------------
        // setup your test

        $classContainer = new PhpContexts\PhpGlobalContext;
        $unit = new GetAllClasses;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = GetAllClasses::from($classContainer);
        $actualResult2 = $unit->getAllClasses($classContainer);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], $actualResult1);
        $this->assertEquals([], $actualResult2);
    }

    /**
     * @covers ::from
     * @covers ::getAllClasses
     */
    public function test_can_get_all_classes_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $classContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasClasses::check($classContainer));
        $this->addMinimalClasses($classContainer);
        $this->assertTrue(PhpReflection\HasClasses::check($classContainer));

        $unit = new GetAllClasses;

        // ----------------------------------------------------------------
        // perform the change

        $classCtxs1 = GetAllClasses::from($classContainer);
        $classCtxs2 = $unit->getAllClasses($classContainer);

        // ----------------------------------------------------------------
        // test the results

        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($classCtxs1));
        $this->assertEquals(2, count($classCtxs1));

        // the class 'FooClass' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpClass::class, $classCtxs1['FooClass']);
        $this->assertEquals('FooClass', $classCtxs1['FooClass']->getName());

        // the class 'BarClass' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpClass::class, $classCtxs1['BarClass']);
        $this->assertEquals('BarClass', $classCtxs1['BarClass']->getName());


        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($classCtxs2));
        $this->assertEquals(2, count($classCtxs2));

        // the class 'FooClass' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpClass::class, $classCtxs2['FooClass']);
        $this->assertEquals('FooClass', $classCtxs2['FooClass']->getName());

        // the class 'BarClass' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpClass::class, $classCtxs2['BarClass']);
        $this->assertEquals('BarClass', $classCtxs2['BarClass']->getName());
    }

}