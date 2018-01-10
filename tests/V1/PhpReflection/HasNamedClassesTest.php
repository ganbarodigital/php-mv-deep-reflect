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
use GanbaroDigital\DeepReflection\V1\PhpReflection\HasNamedClasses;
use GanbaroDigital\MissingBits\Checks\Check;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddClassesToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddClassesToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\HasNamedClasses
 */
class HasNamedClassesTest extends TestCase
{
    use AddClassesToContainer;

    /**
     * @covers ::__construct
     */
    public function test_can_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedClasses = ['FooClass'];

        // ----------------------------------------------------------------
        // perform the change

        $unit = new HasNamedClasses($expectedClasses);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(HasNamedClasses::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_Check()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedClasses = ['FooClass'];

        // ----------------------------------------------------------------
        // perform the change

        $unit = new HasNamedClasses($expectedClasses);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Check::class, $unit);
    }

    /**
     * @covers ::check
     * @covers ::inspect
     */
    public function test_can_check_if_named_classes_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit1 = new HasNamedClasses(['FooClass']);
        $unit2 = new HasNamedClasses(['FooClass', 'BarClass']);
        $unit3 = new HasNamedClasses(['FooClass', 'BarClass', 'not_a_class']);

        $containerWithClasses = new PhpContexts\PhpGlobalContext;
        $this->addMinimalClasses($containerWithClasses);

        $emptyContainer = new PhpContexts\PhpGlobalContext;

        // ----------------------------------------------------------------
        // perform the change

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(HasNamedClasses::check($containerWithClasses, ['not_a_class']));
        $this->assertTrue(HasNamedClasses::check($containerWithClasses, ['FooClass']));
        $this->assertTrue(HasNamedClasses::check($containerWithClasses, ['FooClass', 'BarClass']));
        $this->assertFalse(HasNamedClasses::check($containerWithClasses, ['FooClass', 'BarClass', 'not_a_class']));

        $this->assertTrue($unit1->inspect($containerWithClasses));
        $this->assertTrue($unit2->inspect($containerWithClasses));
        $this->assertFalse($unit3->inspect($containerWithClasses));
        $this->assertFalse($unit1->inspect($emptyContainer));
        $this->assertFalse($unit2->inspect($emptyContainer));
        $this->assertFalse($unit3->inspect($emptyContainer));

    }

}