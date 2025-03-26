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

namespace Storyblok\Tiptap\Extension;

use Storyblok\Tiptap\Node\Blok;
use Storyblok\Tiptap\Node\BulletList;
use Storyblok\Tiptap\Node\CodeBlock;
use Storyblok\Tiptap\Node\Heading;
use Storyblok\Tiptap\Node\ListItem;
use Storyblok\Tiptap\Node\OrderedList;
use Tiptap\Core\Extension;
use Tiptap\Marks\Bold;
use Tiptap\Marks\Code;
use Tiptap\Marks\Highlight;
use Tiptap\Marks\Italic;
use Tiptap\Marks\Link;
use Tiptap\Marks\Strike;
use Tiptap\Marks\Subscript;
use Tiptap\Marks\Superscript;
use Tiptap\Marks\TextStyle;
use Tiptap\Marks\Underline;
use Tiptap\Nodes\Blockquote;
use Tiptap\Nodes\Document;
use Tiptap\Nodes\HardBreak;
use Tiptap\Nodes\HorizontalRule;
use Tiptap\Nodes\Image;
use Tiptap\Nodes\Mention;
use Tiptap\Nodes\Paragraph;
use Tiptap\Nodes\Table;
use Tiptap\Nodes\TableCell;
use Tiptap\Nodes\TableHeader;
use Tiptap\Nodes\TableRow;
use Tiptap\Nodes\TaskItem;
use Tiptap\Nodes\TaskList;
use Tiptap\Nodes\Text;

final class Storyblok extends Extension
{
    /**
     * @param array<string, mixed> $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->options['extensions'] = array_merge($this->addOptions()['extensions'], $options['extensions'] ?? []);
        $this->options['blokOptions'] = array_merge($this->addOptions()['blokOptions'], $options['blokOptions'] ?? []);
    }

    /**
     * @return array<string, mixed>
     */
    public function addOptions(): array
    {
        return [
            'extensions' => [
                'image' => true,
                'text' => true,
                'paragraph' => true,
                'link' => true,
                'blockquote' => true,
                'bold' => true,
                'code' => true,
                'highlight' => true,
                'strike' => true,
                'subscript' => true,
                'superscript' => true,
                'textStyle' => true,
                'italic' => true,
                'underline' => true,
                'hardBreak' => true,
                'document' => true,
                'horizontalRule' => true,
                'mention' => true,
                'taskList' => true,
                'taskItem' => true,
                'table' => true,
                'tableRow' => true,
                'tableCell' => true,
                'tableHeader' => true,
                'bulletList' => true,
                'orderedList' => true,
                'listItem' => true,
                'heading' => true,
                'codeBlock' => true,
                'blok' => true,
            ],
            'blokOptions' => [
                'renderer' => null, // The user must provide a renderer function
            ],
        ];
    }

    /**
     * @return array<Extension>
     */
    public function addExtensions(): array
    {
        return array_filter([
            $this->options['extensions']['image'] ? new Image() : null,
            $this->options['extensions']['text'] ? new Text() : null,
            $this->options['extensions']['paragraph'] ? new Paragraph() : null,
            $this->options['extensions']['link'] ? new Link() : null,
            $this->options['extensions']['blockquote'] ? new Blockquote() : null,
            $this->options['extensions']['bold'] ? new Bold() : null,
            $this->options['extensions']['code'] ? new Code() : null,
            $this->options['extensions']['highlight'] ? new Highlight() : null,
            $this->options['extensions']['strike'] ? new Strike() : null,
            $this->options['extensions']['subscript'] ? new Subscript() : null,
            $this->options['extensions']['superscript'] ? new Superscript() : null,
            $this->options['extensions']['textStyle'] ? new TextStyle() : null,
            $this->options['extensions']['italic'] ? new Italic() : null,
            $this->options['extensions']['underline'] ? new Underline() : null,
            $this->options['extensions']['document'] ? new Document() : null,
            $this->options['extensions']['horizontalRule'] ? new HorizontalRule() : null,
            $this->options['extensions']['mention'] ? new Mention() : null,
            $this->options['extensions']['taskList'] ? new TaskList() : null,
            $this->options['extensions']['taskItem'] ? new TaskItem() : null,
            $this->options['extensions']['hardBreak'] ? new HardBreak() : null,
            $this->options['extensions']['table'] ? new Table() : null,
            $this->options['extensions']['tableRow'] ? new TableRow() : null,
            $this->options['extensions']['tableCell'] ? new TableCell() : null,
            $this->options['extensions']['tableHeader'] ? new TableHeader() : null,
            $this->options['extensions']['bulletList'] ? new BulletList() : null,
            $this->options['extensions']['orderedList'] ? new OrderedList() : null,
            $this->options['extensions']['listItem'] ? new ListItem() : null,
            $this->options['extensions']['heading'] ? new Heading() : null,
            $this->options['extensions']['codeBlock'] ? new CodeBlock() : null,
            $this->options['extensions']['blok'] ? new Blok([
                'renderer' => $this->options['blokOptions']['renderer'],
            ]) : null,
        ]);
    }
}
