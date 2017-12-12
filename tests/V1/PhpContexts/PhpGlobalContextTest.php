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

namespace GanbaroDigitalTest\DeepReflection\V1\PhpContexts;

use GanbaroDigital\DeepReflection\V1\Context;
use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpGlobalContext;
use GanbaroDigital\DeepReflection\V1\PhpReflection;
use GanbaroDigital\DeepReflection\V1\PhpReflectors;
use GanbaroDigital\DeepReflection\V1\PhpScopes;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/PhpFunctionContainerTests.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpContexts\PhpGlobalContext
 */
class PhpGlobalContextTest extends TestCase
{
    protected function getUnitToTest()
    {
        return new PhpGlobalContext();
    }

    /**
     * @covers ::__construct
     */
    public function test_can_instantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new PhpGlobalContext();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpGlobalContext::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_PhpContext()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new PhpGlobalContext();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpContext::class, $unit);
    }

    /**
     * @covers ::getContextType
     */
    public function test_has_ContextType_of_global_namespace()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new PhpGlobalContext();
        $expectedResult = PhpContexts\PhpContextTypes::GLOBAL_CONTEXT;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit->getContextType();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_PhpClassContainer()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new PhpGlobalContext();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpClassContainer::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_PhpFunctionContainer()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new PhpGlobalContext();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpFunctionContainer::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_PhpInterfaceContainer()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new PhpGlobalContext();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpInterfaceContainer::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_PhpNamespaceContainer()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new PhpGlobalContext();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpNamespaceContainer::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_PhpTraitContainer()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new PhpGlobalContext();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpTraitContainer::class, $unit);
    }

    /**
     * @covers ::getName
     */
    public function test_has_name_of_global_namespace()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new PhpGlobalContext();
        $expectedResult = '\\';

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit->getName();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::getInContextName
     */
    public function test_has_same_name_and_InContextName()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new PhpGlobalContext();
        $expectedResult = $unit->getName();

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit->getInContextName();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::getNameAsPrefix
     */
    public function test_getNameAsPrefix_returns_empty_string()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new PhpGlobalContext();
        $expectedResult = '';

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit->getNameAsPrefix();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    // ==================================================================
    //
    // PhpFunctionContainer tests
    //
    // ------------------------------------------------------------------

    use PhpFunctionContainerTests;

    /**
     * @covers ::getChildrenByType
     */
    public function test_namespaced_functions_do_not_appear_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));
        $this->assertFalse(PhpReflection\HasNamespaces::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalNamespacedFunctions($unit);

        // ----------------------------------------------------------------
        // test the results

        // make sure the namespace was created
        $this->assertTrue(PhpReflection\HasNamespaces::check($unit));
        $this->assertTrue(PhpReflection\HasNamespace::check($unit, 'GanbaroDigitalTest\\Fixtures'));
        $namespaceCtx = PhpReflection\GetNamespace::from($unit, 'GanbaroDigitalTest\\Fixtures');
        $this->assertEquals(['foo', 'bar'], PhpReflection\GetFunctionNames::from($namespaceCtx));

        // make sure none of this ended up in the global namespace
        $this->assertFalse(PhpReflection\HasFunctions::check($unit));
        $this->assertEquals([], PhpReflection\GetFunctionNames::from($unit));
    }


    // ==================================================================
    //
    // Namespace Container Tests
    //
    // ------------------------------------------------------------------


    // ==================================================================
    //
    // Class Container Tests
    //
    // ------------------------------------------------------------------


    // ==================================================================
    //
    // Interface Container Tests
    //
    // ------------------------------------------------------------------


    // ==================================================================
    //
    // Trait Container Tests
    //
    // ------------------------------------------------------------------

}