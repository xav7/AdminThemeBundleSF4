<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Tests;

use Avanzu\AdminThemeBundle\AvanzuAdminThemeBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function registerBundles(): array
    {
        $bundles = [];

        if ($this->getEnvironment() === 'test') {
            $bundles[] = new FrameworkBundle();
            $bundles[] = new AvanzuAdminThemeBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/../Resources/config/routes.yml');
        $loader->load(__DIR__ . '/../Resources/config/services.yml');
        $loader->load(__DIR__ . '/../Resources/config/services_test.yml');
        $loader->load(__DIR__ . '/../Resources/config/config_test.yml');
    }
}

