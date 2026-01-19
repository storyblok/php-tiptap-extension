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

namespace Storyblok\Tiptap\Mark;

use Tiptap\Core\Mark;
use Tiptap\Utils\HTML;

final class Anchor extends Mark
{
    public static $name = 'anchor';

    public function addAttributes(): array
    {
        return [
            'id' => [],
        ];
    }

    public function renderHTML($mark, $HTMLAttributes = []): array
    {
        return [
            'span',
            HTML::mergeAttributes(['id' => $mark->attrs->id ?? null], $HTMLAttributes),
            0,
        ];
    }
}
