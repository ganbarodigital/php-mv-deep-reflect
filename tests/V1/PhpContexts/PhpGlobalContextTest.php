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

require_once(__DIR__ . '/PhpClassContainerTests.php');
require_once(__DIR__ . '/PhpFunctionContainerTests.php');
require_once(__DIR__ . '/PhpInterfaceContainerTests.php');
require_once(__DIR__ . '/PhpNamespaceContainerTests.php');
require_once(__DIR__ . '/PhpTraitContainerTests.php');

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
    public function test_namespaced_functions_do_not_appear_in_global_namespace()
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
        $this->assertTrue(PhpReflection\HasNamespaceCalled::check('GanbaroDigitalTest\\Fixtures', $unit));
        $namespaceCtx = PhpReflection\GetNamespace::from('GanbaroDigitalTest\\Fixtures', $unit);
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

    use PhpNamespaceContainerTests;

    /**
     * @covers ::getChildrenByType
     */
    public function test_get_all_namespaces_from_global_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $unit->createNamespace($unit->getScope(), 'FooBar');
        $unit->createNamespace($unit->getScope(), 'BarBaz');

        // ----------------------------------------------------------------
        // perform the change

        $namespaceCtxs = PhpReflection\GetAllNamespaces::from($unit);

        // ----------------------------------------------------------------
        // test the results

        // make sure we have the correctly-sized array first
        $this->assertEquals('array', gettype($namespaceCtxs));
        $this->assertEquals(2, count($namespaceCtxs));

        $this->assertInstanceOf(PhpContexts\PhpNamespace::class, $namespaceCtxs['FooBar']);
        $this->assertEquals('FooBar', $namespaceCtxs['FooBar']->getName());

        $this->assertInstanceOf(PhpContexts\PhpNamespace::class, $namespaceCtxs['BarBaz']);
        $this->assertEquals('BarBaz', $namespaceCtxs['BarBaz']->getName());
    }

    /**
     * @covers ::createNamespace
     */
    public function test_can_create_new_namespaces()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $scope = $unit->getScope();

        // ----------------------------------------------------------------
        // perform the change

        $namespaceCtx = $unit->createNamespace($scope, 'FooBar');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpNamespace::class, $namespaceCtx);
        $this->assertEquals('FooBar', $namespaceCtx->getName());
    }

    /**
     * @covers ::createNamespace
     * @covers ::getChildrenByType
     */
    public function test_multiple_calls_to_createNamespace_will_return_same_PhpNamespace_back()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $scope = $unit->getScope();
        $expectedResult = $unit->createNamespace($scope, 'FooBar');

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = $unit->createNamespace($scope, 'FooBar');
        $actualResult2 = $unit->createNamespace($scope, 'FooBar');

        // for final proof, bypass createNamespace() entirely
        $actualResult3 = PhpReflection\GetNamespace::from('FooBar', $unit);

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame($expectedResult, $actualResult1);
        $this->assertSame($expectedResult, $actualResult2);
        $this->assertSame($expectedResult, $actualResult3);
    }



    // ==================================================================
    //
    // Class Container Tests
    //
    // ------------------------------------------------------------------

    use PhpClassContainerTests;

    /**
     * @covers ::getChildrenByType
     */
    public function test_namespaced_classes_do_not_appear_in_global_namespace()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasClasses::check($unit));
        $this->assertFalse(PhpReflection\HasNamespaces::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalNamespacedClasses($unit);

        // ----------------------------------------------------------------
        // test the results

        // make sure the namespace was created
        $this->assertTrue(PhpReflection\HasNamespaces::check($unit));
        $this->assertTrue(PhpReflection\HasNamespaceCalled::check('GanbaroDigitalTest\\Fixtures', $unit));
        $namespaceCtx = PhpReflection\GetNamespace::from('GanbaroDigitalTest\\Fixtures', $unit);
        $this->assertEquals(['FooClass', 'BarClass'], PhpReflection\GetClassNames::from($namespaceCtx));

        // make sure none of this ended up in the global namespace
        $this->assertFalse(PhpReflection\HasClasses::check($unit));
        $this->assertEquals([], PhpReflection\GetClassNames::from($unit));
    }

    // ==================================================================
    //
    // Interface Container Tests
    //
    // ------------------------------------------------------------------

    use PhpInterfaceContainerTests;

    /**
     * @covers ::getChildrenByType
     */
    public function test_namespaced_interfaces_do_not_appear_in_global_namespace()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));
        $this->assertFalse(PhpReflection\HasNamespaces::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalNamespacedInterfaces($unit);

        // ----------------------------------------------------------------
        // test the results

        // make sure the namespace was created
        $this->assertTrue(PhpReflection\HasNamespaces::check($unit));
        $this->assertTrue(PhpReflection\HasNamespaceCalled::check('GanbaroDigitalTest\\Fixtures', $unit));
        $namespaceCtx = PhpReflection\GetNamespace::from('GanbaroDigitalTest\\Fixtures', $unit);
        $this->assertEquals(['FooInterface', 'BarInterface'], PhpReflection\GetInterfaceNames::from($namespaceCtx));

        // make sure none of this ended up in the global namespace
        $this->assertFalse(PhpReflection\HasInterfaces::check($unit));
        $this->assertEquals([], PhpReflection\GetInterfaceNames::from($unit));
    }

    // ==================================================================
    //
    // Trait Container Tests
    //
    // ------------------------------------------------------------------

    use PhpTraitContainerTests;

    /**
     * @covers ::getChildrenByType
     */
    public function test_namespaced_traits_do_not_appear_in_global_namespace()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $this->assertFalse(PhpReflection\HasTraits::check($unit));
        $this->assertFalse(PhpReflection\HasNamespaces::check($unit));

        // ----------------------------------------------------------------
        // perform the change

        $this->addMinimalNamespacedTraits($unit);

        // ----------------------------------------------------------------
        // test the results

        // make sure the namespace was created
        $this->assertTrue(PhpReflection\HasNamespaces::check($unit));
        $this->assertTrue(PhpReflection\HasNamespaceCalled::check('GanbaroDigitalTest\\Fixtures', $unit));
        $namespaceCtx = PhpReflection\GetNamespace::from('GanbaroDigitalTest\\Fixtures', $unit);
        $this->assertEquals(['FooTrait', 'BarTrait'], PhpReflection\GetTraitNames::from($namespaceCtx));

        // make sure none of this ended up in the global namespace
        $this->assertFalse(PhpReflection\HasTraits::check($unit));
        $this->assertEquals([], PhpReflection\GetTraitNames::from($unit));
    }
}