<?php declare(strict_types=1);

/*
 * This file is part of ToInlineStyleEmailBundle.
 *
 * (c) Roberto Trunfio <roberto@trunfio.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VysokeSkoly\ToInlineStyleEmailBundle\Twig;

use Symfony\Component\Config\FileLocatorInterface;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class InlineCssParser extends AbstractTokenParser
{
    /**
     * @param FileLocatorInterface $locator used to get css asset real path
     * @param string $webRoot web root of the project
     * @param bool $debug in debug mode css is not inlined but read on each render
     */
    public function __construct(private FileLocatorInterface $locator, protected string $webRoot, private bool $debug = false)
    {
    }

    /**
     * Parses a token and returns a node.
     */
    public function parse(Token $token): Node
    {
        $lineNo = $token->getLine();
        $stream = $this->parser->getStream();

        $css = $stream->test(Token::STRING_TYPE)
            ? $this->resolvePath($stream->expect(Token::STRING_TYPE)->getValue())
            : $this->parser->getExpressionParser()->parseExpression();

        $stream->expect(Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse([$this, 'decideEnd'], true);
        $stream->expect(Token::BLOCK_END_TYPE);

        return new InlineCssNode($body, $css, $lineNo, $this->debug);
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag(): string
    {
        return 'inlinecss';
    }

    public function decideEnd(Token $token): bool
    {
        return $token->test('endinlinecss');
    }

    /**
     * Resolve path to absolute if any bundle is mentioned
     */
    private function resolvePath(string $path): string
    {
        try {
            $path = $this->locator->locate($path, $this->webRoot);

            return is_array($path)
                ? reset($path)
                : $path;
        } catch (\InvalidArgumentException $e) {
            // happens when path is not bundle relative
            return $this->webRoot . '/' . $path;
        }
    }
}
