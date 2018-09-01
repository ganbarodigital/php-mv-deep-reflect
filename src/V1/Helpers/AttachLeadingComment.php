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
use GanbaroDigital\DeepReflection\V1\Context;
use GanbaroDigital\DeepReflection\V1\PhpContexts;
use GanbaroDigital\DeepReflection\V1\PhpReflectors;
use GanbaroDigital\DeepReflection\V1\Scope;
use Microsoft\PhpParser\Node;

/**
 * extract a docbloc or other leading comment, and attach it to
 * our context object
 */
class AttachLeadingComment
{
    /**
     * extract a docblock or other leading comment, and attach it to
     * our context object
     *
     * @param  Node $node
     *         the parser node to inspect
     * @param  Context $context
     *         the thing that might have been commented upon
     * @return void
     */
    public static function using(Node $node, Context $context, Scope $activeScope)
    {
        // does it have a leading comment?
        $text = ltrim($node->getLeadingCommentAndWhitespaceText());
        if (empty($text)) {
            return;
        }

        // there may be multiple comments here
        $comments = SeparateComments::using($text);

        // we only want the last one
        $comment = end($comments);

        // and only if there isn't a blank line after it
        if (substr(StripTrailingWhitespace::from($comment), -2) == PHP_EOL . PHP_EOL) {
            return;
        }

        // if we get here, we have a docblock or other comment
        // that is immediately before $node
        $commentCtx = self::reflectComment($comment, $activeScope);
        $context->attachChildContext($commentCtx->getName(), $commentCtx);
    }

    private static function reflectComment($comment, Scope $activeScope)
    {
        if (Checks\IsDocblock::check($comment)) {
            return PhpReflectors\ReflectDocblock::from($comment, $activeScope);
        }
        else if (Checks\IsComment::check($comment)) {
            return new PhpContexts\CommentContext($comment);
        }

        // if we get here, something has gone badly wrong!
        var_dump($comment);
        throw new \RuntimeException("unreachable code ... has been reached (:scream:)");
    }
}