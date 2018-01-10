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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllFunctions;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddFunctionsToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddFunctionsToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllFunctions
 */
class GetAllFunctionsTest extends TestCase
{
    use AddFunctionsToContainer;

    /**
     * @coversNothing
     */
    public function test_can_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = new GetAllFunctions;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(GetAllFunctions::class, $unit);
    }

    /**
     * @covers ::from
     * @covers ::getAllFunctions
     */
    public function test_returns_empty_array_when_no_functions_in_function_container()
    {
        // ----------------------------------------------------------------
        // setup your test

        $funcContainer = new PhpContexts\PhpGlobalContext;
        $unit = new GetAllFunctions;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = GetAllFunctions::from($funcContainer);
        $actualResult2 = $unit->getAllFunctions($funcContainer);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], $actualResult1);
        $this->assertEquals([], $actualResult2);
    }

    /**
     * @covers ::from
     * @covers ::getAllFunctions
     */
    public function test_can_get_all_functions_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $funcContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasFunctions::check($funcContainer));
        $this->addMinimalFunctions($funcContainer);
        $this->assertTrue(PhpReflection\HasFunctions::check($funcContainer));

        $unit = new GetAllFunctions;

        // ----------------------------------------------------------------
        // perform the change

        $funcCtxs1 = GetAllFunctions::from($funcContainer);
        $funcCtxs2 = $unit->getAllFunctions($funcContainer);

        // ----------------------------------------------------------------
        // test the results

        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($funcCtxs1));
        $this->assertEquals(2, count($funcCtxs1));

        // the function 'foo' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpFunction::class, $funcCtxs1['foo']);
        $this->assertEquals('foo', $funcCtxs1['foo']->getName());

        // the function 'bar' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpFunction::class, $funcCtxs1['bar']);
        $this->assertEquals('bar', $funcCtxs1['bar']->getName());


        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($funcCtxs2));
        $this->assertEquals(2, count($funcCtxs2));

        // the function 'foo' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpFunction::class, $funcCtxs2['foo']);
        $this->assertEquals('foo', $funcCtxs2['foo']->getName());

        // the function 'var' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpFunction::class, $funcCtxs2['bar']);
        $this->assertEquals('bar', $funcCtxs2['bar']->getName());
    }

}