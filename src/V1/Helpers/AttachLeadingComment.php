<?php

/**
 * Copyright (c) 2017-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   DeepReflection/Helpers
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-deep-reflection
 */

namespace GanbaroDigital\DeepReflection\V1\Helpers;

use GanbaroDigital\DeepReflection\V1\Checks;
use GanbaroDigital\DeepReflection\V1\Contexts;
use GanbaroDigital\DeepReflection\V1\Reflectors;
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
     * @param  Contexts\Context $context
     *         the thing that might have been commented upon
     * @return void
     */
    public static function using(Node $node, Contexts\Context $context, Scope $activeScope)
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
        if (substr($comment, -2) == PHP_EOL . PHP_EOL) {
            return;
        }

        // if we get here, we have a docblock or other comment
        // that is immediately before $node
        $commentCtx = self::reflectComment($comment, $activeScope);
        $context->attachChildContext($commentCtx);
    }

    private static function reflectComment($comment, Scope $activeScope)
    {
        if (Checks\IsDocblock::check($comment)) {
            return Reflectors\ReflectDocblock::from($comment, $activeScope);
        }
        else if (Checks\IsComment::check($comment)) {
            return new Contexts\CommentContext($comment);
        }

        // if we get here, something has gone badly wrong!
        throw new \RuntimeException("unreachable code ... has been reached (:scream:)");
    }
}