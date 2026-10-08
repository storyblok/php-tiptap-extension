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
use function Safe\preg_match;
use function Safe\preg_replace;

class Link extends Mark
{
    /**
     * Port of the DOMPurify helper used by Tiptap's Link extension.
     *
     * @see https://github.com/ueberdosis/tiptap/blob/next/packages/extension-link/src/link.ts
     */
    private const string ATTR_WHITESPACE = '/[\x00-\x20\x{00A0}\x{1680}\x{180E}\x{2000}-\x{2029}\x{205F}\x{3000}]/u';
    private const array DEFAULT_ALLOWED_PROTOCOLS = [
        'http', 'https', 'ftp', 'ftps', 'mailto', 'tel', 'callto', 'sms', 'cid', 'xmpp',
    ];
    public static $name = 'link';

    public function addOptions()
    {
        return [
            'HTMLAttributes' => [],
            'allowedProtocols' => self::DEFAULT_ALLOWED_PROTOCOLS,
            'isAllowedUri' => fn ($uri) => $this->isAllowedUri($uri),
        ];
    }

    public function isAllowedUri(mixed $uri): bool
    {
        if (null === $uri || '' === $uri) {
            return true;
        }

        if (!\is_string($uri)) {
            return false;
        }

        $sanitized = preg_replace(self::ATTR_WHITESPACE, '', $uri);

        $pattern = '/^(?:(?:'.implode('|', array_map(static fn (string $protocol): string => preg_quote($protocol, '/'), $this->options['allowedProtocols'] ?? self::DEFAULT_ALLOWED_PROTOCOLS))
            .'):|[^a-z]|[a-z0-9+.\-]+(?:[^a-z+.\-:]|$))/i';

        return 1 === preg_match($pattern, $sanitized);
    }

    public function parseHTML()
    {
        return [
            [
                'tag' => 'a[href]',
                'getAttrs' => function ($DOMNode) {
                    $href = $DOMNode->getAttribute('href');

                    if ('' === $href || !$this->checkUri($href)) {
                        return false;
                    }

                    return null;
                },
            ],
        ];
    }

    public function addAttributes()
    {
        return [
            'href' => [],
            'target' => [],
            'rel' => [],
        ];
    }

    public function renderHTML($mark, $HTMLAttributes = [])
    {
        if (isset($mark->attrs->linktype) && 'email' === $mark->attrs->linktype) {
            $HTMLAttributes['href'] = 'mailto:'.$mark->attrs->href;
        }

        if (isset($mark->attrs->anchor) && $mark->attrs->anchor) {
            $HTMLAttributes['href'] = $mark->attrs->href.'#'.$mark->attrs->anchor;
        }

        if (!$this->checkUri($HTMLAttributes['href'] ?? null)) {
            $HTMLAttributes['href'] = '';
        }

        if (isset($mark->attrs->custom)) {
            foreach ($mark->attrs->custom as $key => $value) {
                $HTMLAttributes[$key] = $value;
            }
        }

        return [
            'a',
            HTML::mergeAttributes($this->options['HTMLAttributes'], $HTMLAttributes),
            0,
        ];
    }

    /**
     * Subclasses may override addOptions() without the sanitization options,
     * so fall back to the built-in check to stay backwards compatible.
     */
    private function checkUri(mixed $uri): bool
    {
        $isAllowedUri = $this->options['isAllowedUri'] ?? null;

        return \is_callable($isAllowedUri) ? (bool) $isAllowedUri($uri) : $this->isAllowedUri($uri);
    }
}
