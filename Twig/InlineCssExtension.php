<?php
/**
 * User: avasilenko
 * Date: 5/2/13
 * Time: 17:56
 */
namespace RobertoTru\ToInlineStyleEmailBundle\Twig;

use RobertoTru\ToInlineStyleEmailBundle\Converter\ToInlineStyleEmailConverter;
use Symfony\Bundle\FrameworkBundle\Templating\Loader\TemplateLocator;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\Templating\TemplateNameParserInterface;

class InlineCssExtension extends \Twig_Extension 
{
    /**
     * @var ToInlineStyleEmailConverter
     */
    private $inlineCss;
    /**
     * @var string
     */
    private $kernelRoot;
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Templating\Loader\TemplateLocator
     */
    private $locator;
    /**
     * @var bool
     */
    private $debug;

    public function __construct(ToInlineStyleEmailConverter $inlineCss, FileLocatorInterface $locator, $kernelRoot, $debug = false)
    {
        $this->inlineCss = $inlineCss;
        $this->locator = $locator;
        $this->kernelRoot = $kernelRoot;
        $this->debug = $debug;
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenParsers()
    {
        return [new InlineCssParser($this->locator, $this->kernelRoot . '/../web', $this->debug)];
    }

    /**
     * {@inheritDoc}
     */
    public function getGlobals()
    {
        return array (
            'inlinecss' => $this->inlineCss,
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'inlinecss';
    }
}
