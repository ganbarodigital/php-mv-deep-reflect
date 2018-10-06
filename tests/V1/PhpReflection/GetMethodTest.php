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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetMethod;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddMethodsToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddMethodsToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetMethod
 */
class GetMethodTest extends TestCase
{
    use AddMethodsToContainer;

    /**
     * @covers ::__construct
     * @expectedException Error
     */
    public function test_cannot_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = new GetMethod;

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::from
     */
    public function test_can_get_named_method_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $globalCtx = new PhpContexts\PhpGlobalContext;
        $this->addMinimalMethods($globalCtx);

        // ----------------------------------------------------------------
        // perform the change

        $classCtx = PhpReflection\GetClass::from('BarClassWithMethods', $globalCtx);
        $actualResult = GetMethod::from('firstBarMethod', $classCtx);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpMethod::class, $actualResult);
        $this->assertEquals('firstBarMethod', $actualResult->getName());
    }

    /**
     * @covers ::from
     * @expectedException GanbaroDigital\DeepReflection\V1\PhpExceptions\NoSuchMethod
     */
    public function test_throws_NoSuchMethod_when_named_method_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $globalCtx = new PhpContexts\PhpGlobalContext;
        $this->addMinimalMethods($globalCtx);

        // ----------------------------------------------------------------
        // perform the change

        $classCtx = PhpReflection\GetClass::from('BarClassWithMethods', $globalCtx);
        GetMethod::from('not_a_method', $classCtx);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::from
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage VIVA LA REVOLUTION
     */
    public function test_can_override_failure_action_when_named_method_not_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $globalCtx = new PhpContexts\PhpGlobalContext;
        $this->addMinimalMethods($globalCtx);

        $onFatal = new OnFatal(function($context, $name) {
            throw new \InvalidArgumentException("VIVA LA REVOLUTION");
        });

        // ----------------------------------------------------------------
        // perform the change

        $classCtx = PhpReflection\GetClass::from('BarClassWithMethods', $globalCtx);
        GetMethod::from('not_a_method', $classCtx, $onFatal);
    }

}