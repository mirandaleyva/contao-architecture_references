<?php

declare(strict_types=1);

namespace MirandaLeyva\ContaoArchitectureReferences\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use MirandaLeyva\ContaoArchitectureReferences\MirandaLeyvaContaoArchitectureReferencesBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

final class Plugin implements BundlePluginInterface, ConfigPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(MirandaLeyvaContaoArchitectureReferencesBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig): void
    {
        $loader->load(__DIR__.'/../Resources/config/services.yaml');
    }
}