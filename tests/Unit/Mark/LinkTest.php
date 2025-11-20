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

namespace Storyblok\Tiptap\Tests\Unit\Mark;

use PHPUnit\Framework\TestCase;
use Storyblok\Tiptap\Mark\Link;
use Tiptap\Editor;

final class LinkTest extends TestCase
{
    /**
     * @test
     */
    public function name(): void
    {
        self::assertSame('link', (new Link())::$name);
    }

    /**
     * @test
     */
    public function addOptions(): void
    {
        self::assertSame([
            'HTMLAttributes' => [],
        ], (new Link())->addOptions());
    }

    /**
     * @test
     */
    public function prependsMailto(): void
    {
        $document = [
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'text',
                    'text' => 'Example Email',
                    'marks' => [
                        [
                            'type' => 'link',
                            'attrs' => [
                                'href' => 'hello@example.com',
                                'linktype' => 'email',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = (new Editor([
            'extensions' => [
                new Link(),
            ],
        ]))->setContent($document)->getHTML();

        self::assertSame('<a href="mailto:hello@example.com">Example Email</a>', $result);
    }

    /**
     * @test
     */
    public function appendsAnchors(): void
    {
        $document = [
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'text',
                    'text' => 'Example Link',
                    'marks' => [
                        [
                            'type' => 'link',
                            'attrs' => [
                                'href' => 'https://storyblok.com',
                                'anchor' => 'anchor',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = (new Editor([
            'extensions' => [
                new Link(),
            ],
        ]))->setContent($document)->getHTML();

        self::assertSame('<a href="https://storyblok.com#anchor">Example Link</a>', $result);
    }

    /**
     * @test
     */
    public function addsCustomAttributes(): void
    {
        $document = [
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'text',
                    'text' => 'Example Link',
                    'marks' => [
                        [
                            'type' => 'link',
                            'attrs' => [
                                'href' => 'https://storyblok.com',
                                'custom' => [
                                    'title' => 'title',
                                    'custom' => 'custom',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = (new Editor([
            'extensions' => [
                new Link(),
            ],
        ]))->setContent($document)->getHTML();

        self::assertSame('<a href="https://storyblok.com" title="title" custom="custom">Example Link</a>', $result);
    }
}
