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
    public function __construct(
        private ToInlineStyleEmailConverter $inlineCss,
        private FileLocatorInterface $locator,
        private string $kernelRoot,
        private string $webDir,
        private bool $debug = false,
    ) {
    }

    public function getTokenParsers(): array
    {
        return [new InlineCssParser($this->locator, $this->kernelRoot . '/' . $this->webDir, $this->debug)];
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
