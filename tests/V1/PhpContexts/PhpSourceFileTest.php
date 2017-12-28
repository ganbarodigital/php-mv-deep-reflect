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
use GanbaroDigital\DeepReflection\V1\PhpContexts\PhpSourceFile;
use GanbaroDigital\DeepReflection\V1\PhpReflection;
use GanbaroDigital\DeepReflection\V1\PhpReflectors\ReflectSourceCode;
use GanbaroDigital\DeepReflection\V1\PhpScopes;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/PhpClassContainerTests.php');
require_once(__DIR__ . '/PhpFunctionContainerTests.php');
require_once(__DIR__ . '/PhpInterfaceContainerTests.php');
require_once(__DIR__ . '/PhpNamespaceContainerTests.php');
require_once(__DIR__ . '/PhpTraitContainerTests.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpContexts\PhpSourceFile
 */
class PhpSourceFileTest extends TestCase
{
    const MINIMAL_GLOBAL_FUNCTIONS = __DIR__ . '/../PhpFixtures/BasicGlobalExamples/MinimalFunctions.php';
    const MINIMAL_NAMESPACED_FUNCTIONS = __DIR__ . '/../PhpFixtures/BasicNamespacedExamples/MinimalFunctions.php';

    const MINIMAL_GLOBAL_CLASS_FOO = __DIR__ . '/../PhpFixtures/BasicGlobalExamples/MinimalClassFoo.php';
    const MINIMAL_GLOBAL_CLASS_BAR = __DIR__ . '/../PhpFixtures/BasicGlobalExamples/MinimalClassBar.php';
    const MINIMAL_GLOBAL_INTERFACE_FOO = __DIR__ . '/../PhpFixtures/BasicGlobalExamples/MinimalInterfaceFoo.php';
    const MINIMAL_GLOBAL_INTERFACE_BAR = __DIR__ . '/../PhpFixtures/BasicGlobalExamples/MinimalInterfaceBar.php';
    const MINIMAL_GLOBAL_TRAIT_FOO = __DIR__ . '/../PhpFixtures/BasicGlobalExamples/MinimalTraitFoo.php';
    const MINIMAL_GLOBAL_TRAIT_BAR = __DIR__ . '/../PhpFixtures/BasicGlobalExamples/MinimalTraitBar.php';

    const MINIMAL_NAMESPACED_CLASS_FOO = __DIR__ . '/../PhpFixtures/BasicNamespacedExamples/MinimalClassFoo.php';
    const MINIMAL_NAMESPACED_CLASS_BAR = __DIR__ . '/../PhpFixtures/BasicNamespacedExamples/MinimalClassBar.php';
    const MINIMAL_NAMESPACED_INTERFACE_FOO = __DIR__ . '/../PhpFixtures/BasicNamespacedExamples/MinimalInterfaceFoo.php';
    const MINIMAL_NAMESPACED_INTERFACE_BAR = __DIR__ . '/../PhpFixtures/BasicNamespacedExamples/MinimalInterfaceBar.php';
    const MINIMAL_NAMESPACED_TRAIT_FOO = __DIR__ . '/../PhpFixtures/BasicNamespacedExamples/MinimalTraitFoo.php';
    const MINIMAL_NAMESPACED_TRAIT_BAR = __DIR__ . '/../PhpFixtures/BasicNamespacedExamples/MinimalTraitBar.php';


    protected function getUnitToTest()
    {
        $globalCtx = new PhpGlobalContext();
        $unit = new PhpSourceFile(
            $globalCtx->getScope(),
            '/dev/null'
        );

        return $unit;
    }

    /**
     * @covers ::__construct
     */
    public function test_can_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $globalCtx = new PhpGlobalContext();
        $scope = $globalCtx->getScope();
        $unit = new PhpSourceFile($scope, "/dev/null");

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpSourceFile::class, $unit);
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

        $globalCtx = new PhpGlobalContext();
        $scope = $globalCtx->getScope();
        $unit = new PhpSourceFile($scope, "/dev/null");

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(PhpContexts\PhpContext::class, $unit);
    }

    /**
     * @covers ::getContextType
     */
    public function test_has_ContextType_of_source_file()
    {
        // ----------------------------------------------------------------
        // setup your test

        $globalCtx = new PhpGlobalContext();
        $scope = $globalCtx->getScope();
        $unit = new PhpSourceFile($scope, "/dev/null");

        $expectedResult = PhpContexts\PhpContextTypes::SOURCEFILE_CONTEXT;

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
    public function test_getName_returns_filename_set_in_constructor()
    {
        // ----------------------------------------------------------------
        // setup your test

        $globalCtx = new PhpGlobalContext();
        $scope = $globalCtx->getScope();
        $unit = new PhpSourceFile($scope, "/dev/null");

        $expectedResult = '/dev/null';

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

        $globalCtx = new PhpGlobalContext();
        $scope = $globalCtx->getScope();
        $unit = new PhpSourceFile($scope, "/dev/null");

        $expectedResult = $unit->getName();

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit->getInContextName();

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