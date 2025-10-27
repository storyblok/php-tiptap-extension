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

class Link extends Mark
{
    public static $name = 'link';

    public function addOptions()
    {
        return [
            'HTMLAttributes' => [
                'target' => '_blank',
                'rel' => 'noopener noreferrer nofollow',
            ],
        ];
    }

    public function parseHTML()
    {
        return [
            [
                'tag' => 'a[href]',
            ],
        ];
    }

    public function addAttributes()
    {
        return [
            'href' => [],
            'target' => [],
            'rel' => [],
        ];
    }

    public function renderHTML($mark, $HTMLAttributes = [])
    {
        if ($mark->attrs?->linktype === 'email') {
            $HTMLAttributes['href'] = 'mailto:' . $mark->attrs->href;
        }

        if ($mark->attrs?->anchor) {
            $HTMLAttributes['href'] = $mark->attrs->href . '#' . $mark->attrs->anchor;
        }

        if ($mark->attrs?->custom) {
            foreach ($mark->attrs->custom as $key => $value) {
                $HTMLAttributes[$key] = $value;
            }
        }

        return [
            'a',
            HTML::mergeAttributes($this->options['HTMLAttributes'], $HTMLAttributes),
            0,
        ];
    }
}
