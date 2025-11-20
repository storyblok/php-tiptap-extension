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

namespace Storyblok\Tiptap\Tests\Unit\Node;

use PHPUnit\Framework\TestCase;
use Storyblok\Tiptap\Node\HardBreak;

final class HardBreakTest extends TestCase
{
    /**
     * @test
     */
    public function name(): void
    {
        self::assertSame('hard_break', (new HardBreak())::$name);
    }
}
