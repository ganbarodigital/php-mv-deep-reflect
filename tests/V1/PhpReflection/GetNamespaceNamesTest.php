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
use GanbaroDigital\DeepReflection\V1\PhpReflection\GetNamespaceNames;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use GanbaroDigitalTest\DeepReflection\V1\PhpFixtures\AddNamespacesToContainer;
use PhpUnit\Framework\TestCase;

require_once(__DIR__ . '/../PhpFixtures/AddNamespacesToContainer.php');

/**
 * @coversDefaultClass GanbaroDigital\DeepReflection\V1\PhpReflection\GetNamespaceNames
 */
class GetNamespaceNamesTest extends TestCase
{
    use AddNamespacesToContainer;

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

        $unit = new GetNamespaceNames;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(GetNamespaceNames::class, $unit);
    }

    /**
     * @covers ::from
     */
    public function test_returns_empty_array_when_no_namespaces_in_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $context = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasNamespaces::check($context));

        // ----------------------------------------------------------------
        // perform the change


        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals([], GetNamespaceNames::from($context));
    }

    /**
     * @covers ::from
     */
    public function test_can_get_list_of_namespaces_from_context()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedNames = [ 'FooNamespace', 'BarNamespace' ];

        $context = new PhpContexts\PhpGlobalContext;
        $this->assertFalse(PhpReflection\HasNamespaces::check($context));
        $this->addNamespaces($context, ...$expectedNames);
        $this->assertTrue(PhpReflection\HasNamespaces::check($context));

        // ----------------------------------------------------------------
        // perform the change

        $actualNames = GetNamespaceNames::from($context);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedNames, $actualNames);
    }
}