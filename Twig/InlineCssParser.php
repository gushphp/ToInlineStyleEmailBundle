<?php

/*
 * This file is part of ToInlineStyleEmailBundle.
 *
 * (c) Roberto Trunfio <roberto@trunfio.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RobertoTru\ToInlineStyleEmailBundle\Twig;

use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Twig_NodeInterface;
use Twig_Token;

class InlineCssParser extends \Twig_TokenParser 
{
    /**
     * @var TemplateNameParserInterface
     */
    private $templateNameParser;

    /**
     * @var FileLocatorInterface
     */
    private $locator;

    /**
     * @var string
     */
    protected $webRoot;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @param FileLocatorInterface $locator used to get css asset real path
     * @param TemplateNameParserInterface $templateNameParser
     * @param string $webRoot web root of the project
     * @param bool $debug in debug mode css is not inlined but read on each render
     */
    public function __construct(FileLocatorInterface $locator, TemplateNameParserInterface $templateNameParser, $webRoot, $debug = false)
    {
        $this->locator = $locator;
        $this->templateNameParser = $templateNameParser;
        $this->webRoot = $webRoot;
        $this->debug = $debug;
    }

    /**
     * Parses a token and returns a node.
     *
     * @param Twig_Token $token A Twig_Token instance
     *
     * @return Twig_NodeInterface A Twig_NodeInterface instance
     */
    public function parse(Twig_Token $token)
    {
        $lineNo = $token->getLine();
        $stream = $this->parser->getStream(); 
        $path = $stream->expect(Twig_Token::STRING_TYPE)->getValue();
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideEnd'), true);
        $stream->expect(Twig_Token::BLOCK_END_TYPE);

        return new InlineCssNode($body, $this->resolvePath($path), $lineNo, $this->debug); 
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag()
    {
        return 'inlinecss';
    }
    
    public function decideEnd(Twig_Token $token)
    {
        return $token->test('endinlinecss');
    }

    /**
     * Resolve path to absolute if any bundle is mentioned
     * @param string $path
     * @return string
     */
    private function resolvePath($path)
    {
        try {
            return $this->locator->locate($this->templateNameParser->parse($path));
        } catch (\InvalidArgumentException $e) {
            // happens when path is not bundle relative
            return $this->webRoot.'/'.$path;
        }
    }
}
