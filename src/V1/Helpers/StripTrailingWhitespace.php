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

namespace GanbaroDigital\DeepReflection\V1\Helpers;

use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Contexts;
use GanbaroDigital\DeepReflection\V1\Reflectors;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node;

/**
 * remove all trailing whitespace from a string
 */
class StripTrailingWhitespace
{
    /**
     * remove all trailing whitespace from a string
     *
     * this *will* convert the string to use the same PHP_EOL as the
     * system you are running the code on
     *
     * i.e. a dos2unix or unix2dos conversion could take place
     *
     * @param  string $input
     *         the text that needs sorting out
     * @return string
     *         $input, with trailing whitespace removed
     */
    public static function from(string $input) : string
    {
        $oldLines = explode("\n", $input);
        $newLines = [];
        foreach ($oldLines as $line) {
            $newLines[] = rtrim($line);
        }

        return implode(PHP_EOL, $newLines);
    }
}