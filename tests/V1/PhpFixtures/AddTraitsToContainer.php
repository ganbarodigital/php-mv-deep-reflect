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

namespace GanbaroDigitalTest\DeepReflection\V1\PhpFixtures;

use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\PhpReflectors;

trait AddTraitsToContainer
{
    protected function addMinimalTraits(PhpContexts\PhpTraitContainer $unit)
    {
        $unit->attachChildContext(
            'FooTrait', new PhpContexts\PhpTrait($unit->getScope(), 'FooTrait')
        );
        $unit->attachChildContext(
            'BarTrait', new PhpContexts\PhpTrait($unit->getScope(), 'BarTrait')
        );
    }

    protected function addMinimalNamespacedTraits(PhpContexts\PhpTraitContainer $unit)
    {
        PhpReflectors\ReflectSourceFile::from(
            __DIR__ . '/../PhpFixtures/BasicNamespacedExamples/MinimalTraitFoo.php',
            $unit->getScope()
        );
        PhpReflectors\ReflectSourceFile::from(
            __DIR__ . '/../PhpFixtures/BasicNamespacedExamples/MinimalTraitBar.php',
            $unit->getScope()
        );
    }
}