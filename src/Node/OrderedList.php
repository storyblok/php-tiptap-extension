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

namespace Storyblok\Tiptap\Node;

use Tiptap\Nodes\OrderedList as BaseOrderedList;

final class OrderedList extends BaseOrderedList
{
    public static $name = 'ordered_list';
}
