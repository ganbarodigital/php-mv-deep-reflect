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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetClass;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddClassesToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddClassesToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetClass
 */
class GetClassTest extends TestCase
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

        $unit = new GetClass;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(GetClass::class, $unit);
    }

    /**
     * @covers ::from
     */
    public function test_can_get_named_class_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $classContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasClasses::check($classContainer));
        $this->addMinimalClasses($classContainer);
        $this->assertTrue(PhpReflection\HasClasses::check($classContainer));

        $unit = new GetClass;

        // ----------------------------------------------------------------
        // perform the change

        $classCtx1 = GetClass::from($classContainer, 'FooClass');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpClass::class, $classCtx1);
        $this->assertEquals('FooClass', $classCtx1->getName());
    }

    /**
     * @covers ::from
     * @expectedException GanbaroDigital\DeepReflection\V1\PhpExceptions\NoSuchClass
     */
    public function test_throws_NoSuchClass_when_named_class_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $classContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasClasses::check($classContainer));
        $this->addMinimalClasses($classContainer);
        $this->assertTrue(PhpReflection\HasClasses::check($classContainer));

        $unit = new GetClass;

        // ----------------------------------------------------------------
        // perform the change

        $functionCtx = GetClass::from($classContainer, 'not_a_class');

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::from
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage VIVA LA REVOLUTION
     */
    public function test_can_override_failure_action_when_named_class_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $classContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasClasses::check($classContainer));
        $this->addMinimalClasses($classContainer);
        $this->assertTrue(PhpReflection\HasClasses::check($classContainer));

        $unit = new GetClass;

        $onFatal = new OnFatal(function($name) {
            throw new \InvalidArgumentException("VIVA LA REVOLUTION");
        });

        // ----------------------------------------------------------------
        // perform the change

        $classCtx = GetClass::from($classContainer, 'not_a_class', $onFatal);
    }

}