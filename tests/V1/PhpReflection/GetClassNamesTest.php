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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetClassNames;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddClassesToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddClassesToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetClassNames
 */
class GetClassNamesTest extends TestCase
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

        $unit = new GetClassNames;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(GetClassNames::class, $unit);
    }

    /**
     * @covers ::from
     * @covers ::__invoke
     */
    public function test_returns_empty_array_when_no_classes_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $classContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasClasses::check($classContainer));

        $unit = new GetClassNames;

        // ----------------------------------------------------------------
        // perform the change


        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], GetClassNames::from($classContainer));
        $this->assertEquals([], $unit($classContainer));
    }

    /**
     * @covers ::from
     * @covers ::__invoke
     */
    public function test_can_get_named_class_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $classContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasClasses::check($classContainer));
        $this->addMinimalClasses($classContainer);
        $this->assertTrue(PhpReflection\HasClasses::check($classContainer));

        $unit = new GetClassNames;

        $expectedClassNames = [ 'FooClass', 'BarClass' ];

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalClasses($classContainer);
        $this->assertTrue(PhpReflection\HasClasses::check($classContainer));

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedClassNames, GetClassNames::from($classContainer));
        $this->assertEquals($expectedClassNames, $unit($classContainer));
    }
}