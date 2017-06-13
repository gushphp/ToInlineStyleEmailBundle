<?php

/*
 * This file is part of ToInlineStyleEmailBundle.
 *
 * (c) Roberto Trunfio <roberto@trunfio.it>
 *
 * Part of the functions and fields description is taken from CSSToInlineStyle
 * project by Tijs Verkoyen <php-css-to-inline-styles@verkoyen.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RobertoTru\ToInlineStyleEmailBundle\Converter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\EngineInterface;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 * ToInlineStyleEmailConverter is a shortcut for using in Symfony2 the utility
 * CssToInlineStyles developed by Tijs Verkoyen.
 *
 * The suggested use of this utility is as a service.
 *
 * @author Roberto Trunfio <roberto@trunfio.it>
 */
class ToInlineStyleEmailConverter
{
    /**
     * Container is used to get template engine instead of direct injection.
     * Direct injection is not used to avoid circular reference exception when rendering using twig tag
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * The class used for CSS-to-inline-style conversion.
     *
     * @var \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles
     */
    protected $cssToInlineStyles;
    /**
     * A string that represents the HTML file to be sent. Twig templates must be
     * rendered and then passed to this class.
     *
     * @var string
     */
    protected $html;
    /**
     * A string that contains the CSS for the HTML file.
     *
     * @var string
     */
    protected $css;

    /**
     * Construct the service.
     *
     * @param ContainerInterface $container container is used to get templating engine
     * for twig templates. This is optional. Set this param when configuring this
     * class as a service.
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->cssToInlineStyles = new CssToInlineStyles();
    }

    /**
     * Set the string which represents the CSS for the HTML file to be sent as email.
     *
     * @param string $css
     */
    public function setCSS($css)
    {
        $this->css = $css;
    }

    /**
     * Set the string which represents the HTML file to be sent as email.
     *
     * @param string $html
     */
    public function setHTML($html)
    {
        $this->html = $html;
    }

    /**
     * Set the string which represents the HTML file to be sent as email by rendering a template.
     *
     * @param string $view is the view to be rendered, e.g. Acme:MyBundle:MyController:index.html.twig
     * @param array[optional] $parameters the array of options to be used for template rendering. This field is optional
     * @throws MissingTemplatingEngineException The TwigEngine must be passed to the constructor, otherwise an exception is thrown
     */
    public function setHTMLByView($view, array $parameters = array())
    {
        if (!$this->container) {
            throw new MissingTemplatingEngineException("To use this function, a Container object must be passed to the constructor (@service_container service)");
        }
        /** @var EngineInterface $engine */
        $engine = $this->container->get('templating');
        $this->setHTML($engine->render($view, $parameters));
    }

    /**
     * Generate the HTML ready to be sent as email.
     *
     * @return string the HTML ready to be sent with an inline-style
     * @throws MissingParamException the HTML and CSS are mandatory.
     */
    public function generateStyledHTML()
    {
        if (is_null($this->html)) {
            throw new MissingParamException("The HTML must be set");
        }

        if (!is_string($this->html)) {
            throw new MissingParamException("The HTML must be a valid string");
        }

        if (is_null($this->css)) {
            throw new MissingParamException("The CSS must be set");
        }

        if (!is_string($this->css)) {
            throw new MissingParamException("The CSS must be a valid string");
        }

        return  $this->cssToInlineStyles->convert($this->html, $this->css);
    }

    /**
     * Inline CSS inside of HTML and return resulting HTML
     * @param string $html
     * @param string $css
     * @return string
     */
    public function inlineCSS($html, $css)
    {
        return $this->cssToInlineStyles->convert($html, $css);
    }
}

