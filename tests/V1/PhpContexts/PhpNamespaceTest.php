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
use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpNamespace;
use GanbaroDigital\DeepReflection\V1\PhpReflectors;
use GanbaroDigital\DeepReflection\V1\PhpScopes;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/PhpClassContainerTests.php');
require_once(__DIR__ . '/PhpFunctionContainerTests.php');
require_once(__DIR__ . '/PhpInterfaceContainerTests.php');
require_once(__DIR__ . '/PhpNamespaceContainerTests.php');
require_once(__DIR__ . '/PhpTraitContainerTests.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpContexts\PhpNamespace
 */
class PhpNamespaceTest extends TestCase
{
    protected function getUnitToTest()
    {
        $globalCtx = new PhpGlobalContext();
        $unit = $globalCtx->createNamespace(
            $globalCtx->getScope(),
            'GanbaroDigitalTest\\Fixtures'
        );

        return $unit;
    }

    /**
     * @covers ::__construct
     */
    public function test_must_be_created_from_GlobalContext()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpNamespace::class, $unit);
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

        $unit = $this->getUnitToTest();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpContext::class, $unit);
    }

    /**
     * @covers ::getContextType
     */
    public function test_has_ContextType_of_namespace()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();

        $expectedResult = PhpContexts\PhpContextTypes::NAMESPACE_CONTEXT;

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
    public function test_has_name_of_namespace_set_in_constructor()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();

        $expectedResult = 'GanbaroDigitalTest\\Fixtures';

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

        $unit = $this->getUnitToTest();
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
    public function test_getNameAsPrefix_returns_namespace_with_separator_suffix()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = $this->getUnitToTest();
        $expectedResult = 'GanbaroDigitalTest\\Fixtures\\';

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit->getNameAsPrefix();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    // ==================================================================
    //
    // Class Container Tests
    //
    // ------------------------------------------------------------------

    use PhpClassContainerTests;

    // ==================================================================
    //
    // FunctionContainer tests
    //
    // ------------------------------------------------------------------

    use PhpFunctionContainerTests;

    // ==================================================================
    //
    // Interface Container Tests
    //
    // ------------------------------------------------------------------

    use PhpInterfaceContainerTests;

    // ==================================================================
    //
    // Namespace Container Tests
    //
    // ------------------------------------------------------------------

    use PhpNamespaceContainerTests;

    // ==================================================================
    //
    // Trait Container Tests
    //
    // ------------------------------------------------------------------

    use PhpTraitContainerTests;

}