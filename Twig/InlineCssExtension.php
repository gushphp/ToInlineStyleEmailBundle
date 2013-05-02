<?php
/**
 * User: avasilenko
 * Date: 5/2/13
 * Time: 17:56
 */
namespace RobertoTru\ToInlineStyleEmailBundle\Twig;

use RobertoTru\ToInlineStyleEmailBundle\Converter\ToInlineStyleEmailConverter;
use Symfony\Bundle\FrameworkBundle\Templating\Loader\TemplateLocator;
use Symfony\Component\Templating\TemplateNameParserInterface;

class InlineCssExtension extends \Twig_Extension 
{
    /**
     * @var ToInlineStyleEmailConverter
     */
    private $inlineCss;
    /**
     * @var TemplateNameParserInterface
     */
    private $templateNameParser;
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Templating\Loader\TemplateLocator
     */
    private $locator;

    public function __construct(ToInlineStyleEmailConverter $inlineCss, TemplateNameParserInterface $templateNameParser, TemplateLocator $locator)
    {
        $this->inlineCss = $inlineCss;
        $this->templateNameParser = $templateNameParser;
        $this->locator = $locator;
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenParsers()
    {
        return [new InlineCssParser($this->templateNameParser, $this->locator)];
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
