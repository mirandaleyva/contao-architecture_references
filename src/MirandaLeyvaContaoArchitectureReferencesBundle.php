<?php

declare(strict_types=1);

namespace MirandaLeyva\ContaoArchitectureReferences;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MirandaLeyvaContaoArchitectureReferencesBundle extends Bundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../Resources/config/services.yaml');
    }
}