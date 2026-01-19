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
use Storyblok\Tiptap\Mark\Anchor;
use Tiptap\Editor;

final class AnchorTest extends TestCase
{
    /**
     * @test
     */
    public function name(): void
    {
        self::assertSame('anchor', (new Anchor())::$name);
    }

    /**
     * @test
     */
    public function addAttributes(): void
    {
        self::assertSame([
            'id' => [],
        ], (new Anchor())->addAttributes());
    }

    /**
     * @test
     */
    public function rendersSpanWithId(): void
    {
        $document = [
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'text',
                    'text' => 'Anchor Text',
                    'marks' => [
                        [
                            'type' => 'anchor',
                            'attrs' => [
                                'id' => 'my-anchor',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = (new Editor([
            'extensions' => [
                new Anchor(),
            ],
        ]))->setContent($document)->getHTML();

        self::assertSame('<span id="my-anchor">Anchor Text</span>', $result);
    }
}
