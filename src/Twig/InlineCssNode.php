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

use Twig\Compiler;
use Twig\Node\Node;

class InlineCssNode extends Node
{
    public function __construct(Node $body, mixed $css, int $lineno, private bool $debug, string $tag = 'inlinecss')
    {
        parent::__construct(['body' => $body], ['css' => $css], $lineno, $tag);
    }

    public function compile(Compiler $compiler): void
    {
        if (is_string($this->getAttribute('css'))) {
            $css = $this->debug
                ? sprintf("file_get_contents('%s')", $this->getAttribute('css'))
                : sprintf('"%s"', addslashes((string) file_get_contents($this->getAttribute('css'))));

            $compiler->addDebugInfo($this)
                ->write("ob_start();\n")
                ->subcompile($this->getNode('body'))
                ->write(sprintf('echo $context["inlinecss"]->inlineCSS(ob_get_clean(), %s);' . "\n", $css));
        } else {
            //get path of css
            $compiler
                ->addDebugInfo($this)
                ->write("ob_start();\n")
                ->write('$css = addslashes(file_get_contents(')
                ->subcompile($this->getAttribute('css'))
                ->raw('));')
                ->subcompile($this->getNode('body'))
                ->write('echo $context["inlinecss"]->inlineCSS(ob_get_clean(), $css);' . "\n");
        }
    }
}
