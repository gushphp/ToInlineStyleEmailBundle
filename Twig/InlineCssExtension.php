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

use RobertoTru\ToInlineStyleEmailBundle\Converter\ToInlineStyleEmailConverter;
use Symfony\Component\Config\FileLocatorInterface;
use Twig\Extension\GlobalsInterface as TwigExtensionGlobalsInterface;

/**
 * Responsible to construct the instance responsible to inject the inline csss.
 *
 * @package RobertoTru\ToInlineStyleEmailBundle\Twig
 */
class InlineCssExtension extends \Twig_Extension implements TwigExtensionGlobalsInterface
{
    /**
     * @var ToInlineStyleEmailConverter
     */
    private $inlineCss;

    /**
     * @var string
     */
    private $webRoot;

    /**
     * @var FileLocatorInterface
     */
    private $locator;

    /**
     * @var bool
     */
    private $debug;

    public function __construct(
        ToInlineStyleEmailConverter $inlineCss,
        FileLocatorInterface $locator,
        $webRoot,
        $debug = false
    ) {
        $this->inlineCss = $inlineCss;
        $this->locator   = $locator;
        $this->webRoot   = $webRoot;
        $this->debug     = $debug;
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenParsers()
    {
        return array(new InlineCssParser($this->locator, $this->webRoot, $this->debug));
    }

    /**
     * {@inheritDoc}
     */
    public function getGlobals()
    {
        return array(
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
