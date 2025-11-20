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

class Styled extends Mark
{
    public static $name = 'styled';

    public function addOptions()
    {
        return [
            'HTMLAttributes' => [
                'class' => '',
            ],
        ];
    }

    public function parseHTML()
    {
        return [
            [
                'tag' => 'span',
            ],
        ];
    }

    public function addAttributes()
    {
        return [
            'class' => [],
        ];
    }

    public function renderHTML($mark, $HTMLAttributes = [])
    {
        return ['span', HTML::mergeAttributes($this->options['HTMLAttributes'], $HTMLAttributes), 0];
    }
}
