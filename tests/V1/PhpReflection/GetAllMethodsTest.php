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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllMethods;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddMethodsToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddMethodsToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllMethods
 */
class GetAllMethodsTest extends TestCase
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

        $unit = new GetAllMethods;

        // ----------------------------------------------------------------
        // test the results

    }

    /**
     * @covers ::from
     */
    public function test_returns_empty_array_when_no_methods_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $globalCtx = new PhpContexts\PhpGlobalContext;
        $classCtx  = new PhpContexts\PhpClassLike(
            $globalCtx->getScope(),
            new PhpContexts\PhpClassLikeName('test')
        );

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = GetAllMethods::from($classCtx);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], $actualResult);
    }

    /**
     * @covers ::from
     */
    public function test_can_get_all_methods_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $globalCtx = new PhpContexts\PhpGlobalContext;
        $this->addMinimalMethods($globalCtx);

        // ----------------------------------------------------------------
        // perform the change

        $classCtx = PhpReflection\GetClass::from('BarClassWithMethods', $globalCtx);
        $actualResult = GetAllMethods::from($classCtx);

        // ----------------------------------------------------------------
        // test the results

        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($actualResult));
        $this->assertEquals(4, count($actualResult));

        // the function 'firstBarMethod' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpMethod::class, $actualResult['firstBarMethod']);
        $this->assertEquals('firstBarMethod', $actualResult['firstBarMethod']->getName());

        // the function 'secondBarMethod' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpMethod::class, $actualResult['secondBarMethod']);
        $this->assertEquals('secondBarMethod', $actualResult['secondBarMethod']->getName());

        // the function 'firstStaticBarMethod' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpMethod::class, $actualResult['firstStaticBarMethod']);
        $this->assertEquals('firstStaticBarMethod', $actualResult['firstStaticBarMethod']->getName());

        // the function 'secondStaticBarMethod' should be in the array
        $this->assertInstanceOf(PhpContexts\PhpMethod::class, $actualResult['secondStaticBarMethod']);
        $this->assertEquals('secondStaticBarMethod', $actualResult['secondStaticBarMethod']->getName());
    }
}