<?php

declare(strict_types=1);

namespace MirandaLeyva\ContaoArchitectureReferences\ContaoManager;

use MirandaLeyva\ContaoArchitectureReferences\MirandaLeyvaContaoArchitectureReferencesBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

final class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(MirandaLeyvaContaoArchitectureReferencesBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
