<?php

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
                'class' => ''
            ],
        ];
    }

    public function parseHTML()
    {
        return [
            [
                'tag' => 'span'
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
