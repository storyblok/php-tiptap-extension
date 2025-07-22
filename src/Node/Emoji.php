<?php

declare(strict_types=1);

namespace Storyblok\Tiptap\Node;

use Tiptap\Core\Node;

final class Emoji extends Node
{
    public static $name = 'emoji';

    public function renderHTML($node)
    {
        if (!isset($node->attrs) || !isset($node->attrs->emoji)) {
            return [];
        }

        return [
            'content' => $node->attrs->emoji,
        ];
    }
}
