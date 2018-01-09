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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllNamespaces;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddNamespacesToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddNamespacesToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetAllNamespaces
 */
class GetAllNamespacesTest extends TestCase
{
    use AddNamespacesToContainer;

    /**
     * @coversNothing
     */
    public function test_can_be_instantiated()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = new GetAllNamespaces;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(GetAllNamespaces::class, $unit);
    }

    /**
     * @covers ::from
     * @covers ::__invoke
     * @covers ::getAllNamespaces
     */
    public function test_returns_empty_array_when_no_namespaces_in_namespace_container()
    {
        // ----------------------------------------------------------------
        // setup your test

        $namespaceContainer = new PhpContexts\PhpGlobalContext;
        $unit = new GetAllNamespaces;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = GetAllNamespaces::from($namespaceContainer);
        $actualResult2 = $unit($namespaceContainer);
        $actualResult3 = $unit->getAllNamespaces($namespaceContainer);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], $actualResult1);
        $this->assertEquals([], $actualResult2);
        $this->assertEquals([], $actualResult3);
    }

    /**
     * @covers ::from
     * @covers ::__invoke
     * @covers ::getAllNamespaces
     */
    public function test_can_get_all_namespaces_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $namespaceContainer = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasNamespaces::check($namespaceContainer));
        $this->addNamespaces($namespaceContainer, 'this\\is\\a\\namespace', 'BarNamespace');
        $this->assertTrue(PhpReflection\HasNamespaces::check($namespaceContainer));

        $unit = new GetAllNamespaces;

        // ----------------------------------------------------------------
        // perform the change

        $namespaceCtxs1 = GetAllNamespaces::from($namespaceContainer);
        $namespaceCtxs2 = $unit($namespaceContainer);
        $namespaceCtxs3 = $unit->getAllNamespaces($namespaceContainer);

        // ----------------------------------------------------------------
        // test the results

        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($namespaceCtxs1));
        $this->assertEquals(2, count($namespaceCtxs1));

        // the namespace 'this\\is\\a\\namespace' should be in the array
        $this->assertTrue(isset($namespaceCtxs1['this\\is\\a\\namespace']));
        $this->assertInstanceOf(PhpContexts\PhpNamespace::class, $namespaceCtxs1['this\\is\\a\\namespace']);
        $this->assertEquals('this\\is\\a\\namespace', $namespaceCtxs1['this\\is\\a\\namespace']->getName());

        // the namespace 'BarNamespace' should be in the array
        $this->assertTrue(isset($namespaceCtxs1['BarNamespace']));
        $this->assertInstanceOf(PhpContexts\PhpNamespace::class, $namespaceCtxs1['BarNamespace']);
        $this->assertEquals('BarNamespace', $namespaceCtxs1['BarNamespace']->getName());


        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($namespaceCtxs2));
        $this->assertEquals(2, count($namespaceCtxs2));

        // the namespace 'this\\is\\a\\namespace' should be in the array
        $this->assertTrue(isset($namespaceCtxs2['this\\is\\a\\namespace']));
        $this->assertInstanceOf(PhpContexts\PhpNamespace::class, $namespaceCtxs2['this\\is\\a\\namespace']);
        $this->assertEquals('this\\is\\a\\namespace', $namespaceCtxs2['this\\is\\a\\namespace']->getName());

        // the namespace 'BarNamespace' should be in the array
        $this->assertTrue(isset($namespaceCtxs2['BarNamespace']));
        $this->assertInstanceOf(PhpContexts\PhpNamespace::class, $namespaceCtxs2['BarNamespace']);
        $this->assertEquals('BarNamespace', $namespaceCtxs2['BarNamespace']->getName());


        // make sure we got back an array of the right size
        $this->assertEquals('array', gettype($namespaceCtxs3));
        $this->assertEquals(2, count($namespaceCtxs3));

        // the namespace 'this\\is\\a\\namespace' should be in the array
        $this->assertTrue(isset($namespaceCtxs3['this\\is\\a\\namespace']));
        $this->assertInstanceOf(PhpContexts\PhpNamespace::class, $namespaceCtxs3['this\\is\\a\\namespace']);
        $this->assertEquals('this\\is\\a\\namespace', $namespaceCtxs3['this\\is\\a\\namespace']->getName());

        // the namespace 'BarNamespace' should be in the array
        $this->assertTrue(isset($namespaceCtxs3['BarNamespace']));
        $this->assertInstanceOf(PhpContexts\PhpNamespace::class, $namespaceCtxs3['BarNamespace']);
        $this->assertEquals('BarNamespace', $namespaceCtxs3['BarNamespace']->getName());
    }

}