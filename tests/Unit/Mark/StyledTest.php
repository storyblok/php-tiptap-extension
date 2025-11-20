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
use Storyblok\Tiptap\Mark\Styled;

final class StyledTest extends TestCase
{
    /**
     * @test
     */
    public function name(): void
    {
        self::assertSame('styled', (new Styled())::$name);
    }

    /**
     * @test
     */
    public function addOptions(): void
    {
        self::assertSame([
            'HTMLAttributes' => [
                'class' => '',
            ],
        ], (new Styled())->addOptions());
    }
}
