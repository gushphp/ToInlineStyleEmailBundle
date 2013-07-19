<?php
/**
 * User: avasilenko
 * Date: 5/2/13
 * Time: 17:30
 */
namespace RobertoTru\ToInlineStyleEmailBundle\Twig;

use Twig_Compiler;

class InlineCssNode extends \Twig_Node 
{
    private $debug;
    
    public function __construct(\Twig_NodeInterface $body, $css, $lineno = 0, $debug, $tag = 'inlinecss')
    {
        $this->debug = $debug;
        parent::__construct(array('body' => $body), array('css' => $css), $lineno, $tag);
    }

    public function compile(Twig_Compiler $compiler)
    {
        if ($this->debug) {
            $css = sprintf("file_get_contents('%s')", $this->getAttribute('css'));
        } else {
            $css = '"' . addslashes(file_get_contents($this->getAttribute('css'))) . '"';
        }
        $compiler->addDebugInfo($this)
            ->write("ob_start();\n")
            ->subcompile($this->getNode('body'))
            ->write(sprintf('echo $context["inlinecss"]->inlineCSS(ob_get_clean(), %s);' . "\n", $css));
    }
}
