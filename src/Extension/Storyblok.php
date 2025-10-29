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

use Storyblok\Tiptap\Mark\Link;
use Storyblok\Tiptap\Mark\Styled;
use Storyblok\Tiptap\Node\Blok;
use Storyblok\Tiptap\Node\BulletList;
use Storyblok\Tiptap\Node\CodeBlock;
use Storyblok\Tiptap\Node\Emoji;
use Storyblok\Tiptap\Node\Heading;
use Storyblok\Tiptap\Node\ListItem;
use Storyblok\Tiptap\Node\OrderedList;
use Tiptap\Core\Extension;
use Tiptap\Marks\Bold;
use Tiptap\Marks\Code;
use Tiptap\Marks\Highlight;
use Tiptap\Marks\Italic;
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

        if (\array_key_exists('extensions', $options)) {
            @trigger_error(
                'Passing "extensions" to the Storyblok extension is deprecated and will be removed in a future version. Use "override_extensions" instead.',
                \E_USER_DEPRECATED,
            );

            $this->options['extensions'] = array_merge($this->addOptions()['extensions'], $options['extensions'] ?? []);
        }

        $this->options['override_extensions'] = array_merge($this->addOptions()['override_extensions'], $options['override_extensions'] ?? []);
        $this->options['disable_extensions'] = array_merge($this->addOptions()['disable_extensions'], $options['disable_extensions'] ?? []);
        $this->options['blokOptions'] = array_merge($this->addOptions()['blokOptions'], $options['blokOptions'] ?? []);
    }

    /**
     * @return array<string, mixed>
     */
    public function addOptions(): array
    {
        return [
            'override_extensions' => [],
            'disable_extensions' => [],
            'extensions' => [],
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
        return \array_filter(\array_merge(
            [
                Image::$name => new Image(),
                Text::$name => new Text(),
                Paragraph::$name => new Paragraph(),
                Link::$name => new Link(),
                Blockquote::$name => new Blockquote(),
                Bold::$name => new Bold(),
                Code::$name => new Code(),
                Highlight::$name => new Highlight(),
                Strike::$name => new Strike(),
                Subscript::$name => new Subscript(),
                Superscript::$name => new Superscript(),
                TextStyle::$name => new TextStyle(),
                Italic::$name => new Italic(),
                Underline::$name => new Underline(),
                Document::$name => new Document(),
                HorizontalRule::$name => new HorizontalRule(),
                Mention::$name => new Mention(),
                TaskList::$name => new TaskList(),
                TaskItem::$name => new TaskItem(),
                HardBreak::$name => new HardBreak(),
                Table::$name => new Table(),
                TableRow::$name => new TableRow(),
                TableCell::$name => new TableCell(),
                TableHeader::$name => new TableHeader(),
                BulletList::$name => new BulletList(),
                OrderedList::$name => new OrderedList(),
                ListItem::$name => new ListItem(),
                Heading::$name => new Heading(),
                CodeBlock::$name => new CodeBlock(),
                Emoji::$name => new Emoji(),
                Styled::$name => new Styled(),
                Blok::$name => new Blok([
                    'renderer' => $this->options['blokOptions']['renderer'],
                ]),
            ],
            $this->options['override_extensions'],
            ...\array_map(static fn (Extension $extension) => [$extension::$name => $extension], \array_filter($this->options['extensions'])),
        ), fn (string $name) => !\in_array($name, $this->options['disable_extensions'], true), \ARRAY_FILTER_USE_KEY);
    }
}
