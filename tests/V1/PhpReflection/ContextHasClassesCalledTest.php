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
use GanbaroDigital\DeepReflection\V1\PhpReflection\ContextHasClassesCalled;
use GanbaroDigital\MissingBits\Checks\Check;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddClassesToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddClassesToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\ContextHasClassesCalled
 */
class ContextHasClassesCalledTest extends TestCase
{
    use AddClassesToContainer;

    /**
     * @covers ::__construct
     */
    public function test_can_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test

        $classContainer = new PhpContexts\PhpGlobalContext;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ContextHasClassesCalled($classContainer);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(ContextHasClassesCalled::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_Check()
    {
        // ----------------------------------------------------------------
        // setup your test

        $classContainer = new PhpContexts\PhpGlobalContext;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ContextHasClassesCalled($classContainer);

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

        $classContainer = new PhpContexts\PhpGlobalContext;
        $this->addMinimalClasses($classContainer);

        $unit = new ContextHasClassesCalled($classContainer);

        // ----------------------------------------------------------------
        // perform the change


        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse(ContextHasClassesCalled::check($classContainer, ['not_a_class']));
        $this->assertTrue(ContextHasClassesCalled::check($classContainer, ['FooClass']));
        $this->assertTrue(ContextHasClassesCalled::check($classContainer, ['FooClass', 'BarClass']));
        $this->assertFalse(ContextHasClassesCalled::check($classContainer, ['FooClass', 'BarClass', 'not_a_class']));

        $this->assertFalse($unit->inspect(['not_a_class']));
        $this->assertTrue($unit->inspect(['FooClass']));
        $this->assertTrue($unit->inspect(['FooClass', 'BarClass']));
        $this->assertFalse($unit->inspect(['FooClass', 'BarClass', 'not_a_class']));
    }

}