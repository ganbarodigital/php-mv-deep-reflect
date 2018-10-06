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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllParameters;
use GanbaroDigital\DeepReflection\V1\PhpReflection\HasParameterCalled;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddMethodsWithParamsToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddMethodsWithParamsToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllParameters
 */
class GetAllParametersTest extends TestCase
{
    use AddMethodsWithParamsToContainer;

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

        $unit = new GetAllParameters;

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::from
     */
    public function test_returns_empty_array_when_no_parameters_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $globalCtx = new PhpContexts\PhpGlobalContext;
        $this->addMinimalMethods($globalCtx);

        $classCtx  = PhpReflection\GetClass::from('FooClassWithMethodsWithParams', $globalCtx);
        $methodCtx = PhpReflection\GetMethod::from('methodWithNoParams', $classCtx);

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = GetAllParameters::from($methodCtx);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], $actualResult);
    }

    /**
     * @covers ::from
     */
    public function test_can_get_all_params_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $globalCtx = new PhpContexts\PhpGlobalContext;
        $this->addMinimalMethods($globalCtx);

        $classCtx  = PhpReflection\GetClass::from('FooClassWithMethodsWithParams', $globalCtx);
        $methodCtx = PhpReflection\GetMethod::from('methodWithFourParams', $classCtx);

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = GetAllParameters::from($methodCtx);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(isset($actualResult['$first']));
        $this->assertTrue($actualResult['$first'] instanceof PhpContexts\PhpFunctionLikeParameter);

        $this->assertTrue(isset($actualResult['$second']));
        $this->assertTrue($actualResult['$second'] instanceof PhpContexts\PhpFunctionLikeParameter);

        $this->assertTrue(isset($actualResult['$third']));
        $this->assertTrue($actualResult['$third'] instanceof PhpContexts\PhpFunctionLikeParameter);

        $this->assertTrue(isset($actualResult['$fourth']));
        $this->assertTrue($actualResult['$fourth'] instanceof PhpContexts\PhpFunctionLikeParameter);
    }

}