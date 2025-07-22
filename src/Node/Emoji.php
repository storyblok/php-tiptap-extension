<?php

declare(strict_types=1);

/**
 * This file is part of Storyblok PHP Tiptap Extension.
 *
 * (c) Storyblok GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Storyblok\Tiptap\Node;

use Tiptap\Core\Node;

final class Emoji extends Node
{
    public static $name = 'emoji';

    /**
     * @param \stdClass $node
     *
     * @return array<string, mixed>
     */
    public function renderHTML($node): array
    {
        if (!isset($node->attrs) || !isset($node->attrs->emoji)) {
            return [];
        }

        return [
            'content' => $node->attrs->emoji,
        ];
    }
}
