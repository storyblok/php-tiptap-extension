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

namespace Storyblok\Tiptap\Tests\Unit\Extension;

use PHPUnit\Framework\TestCase;
use Storyblok\Tiptap\Extension\Storyblok;
use Storyblok\Tiptap\Node\Blok;
use Storyblok\Tiptap\Node\BulletList;
use Storyblok\Tiptap\Node\CodeBlock;
use Storyblok\Tiptap\Node\Heading;
use Storyblok\Tiptap\Node\ListItem;
use Storyblok\Tiptap\Node\OrderedList;
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

final class StoryblokTest extends TestCase
{
    /**
     * @test
     */
    public function addOptions(): void
    {
        self::assertSame([
            'override_extensions' => [],
            'disable_extensions' => [],
            'extensions' => [],
            'blokOptions' => [
                'renderer' => null, // The user must provide a renderer function
            ],
        ], (new Storyblok())->addOptions());
    }

    /**
     * @test
     */
    public function usingDeprecatedExtensionsKey(): void
    {
        $extension = new Storyblok([
            'extensions' => [
                Image::$name => false,
            ],
        ]);

        self::assertArrayNotHasKey('image', $extension->options);
    }

    /**
     * @test
     */
    public function disableExtensions(): void
    {
        $extension = new Storyblok([
            'disable_extensions' => [
                Image::$name,
                Blok::$name,
            ],
        ]);

        self::assertArrayNotHasKey('image', $extension->options);
        self::assertArrayNotHasKey('blok', $extension->options);
    }

    /**
     * @test
     */
    public function usingOverrideExtensions(): void
    {
        $extension = new Storyblok([
            'override_extensions' => [
                'image' => $object = new Image(),
            ]
        ]);

        self::assertSame($object, $extension->addExtensions()['image']);
    }

    /**
     * @test
     */
    public function addExtensions(): void
    {
        self::assertEquals(
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
                Blok::$name => new Blok(),
            ],
            (new Storyblok())->addExtensions(),
        );
    }
}
