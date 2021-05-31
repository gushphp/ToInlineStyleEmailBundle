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
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use VysokeSkoly\ToInlineStyleEmailBundle\Converter\ToInlineStyleEmailConverter;

class InlineCssExtension extends AbstractExtension implements GlobalsInterface
{
    private ToInlineStyleEmailConverter $inlineCss;
    private string $projectRoot;
    private string $webDir;
    private FileLocatorInterface $locator;
    private bool $debug;

    public function __construct(
        ToInlineStyleEmailConverter $inlineCss,
        FileLocatorInterface $locator,
        string $kernelRoot,
        string $webDir,
        bool $debug = false
    ) {
        $this->inlineCss = $inlineCss;
        $this->locator = $locator;
        $this->projectRoot = $kernelRoot;
        $this->webDir = $webDir;
        $this->debug = $debug;
    }

    public function getTokenParsers(): array
    {
        return [new InlineCssParser($this->locator, $this->projectRoot . '/' . $this->webDir, $this->debug)];
    }

    public function getGlobals(): array
    {
        return [
            'inlinecss' => $this->inlineCss,
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName(): string
    {
        return 'inlinecss';
    }
}
