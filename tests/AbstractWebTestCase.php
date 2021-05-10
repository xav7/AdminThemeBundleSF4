<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        self::ensureKernelShutdown();

        $this->client = self::createClient();
    }

    protected function tearDown(): void
    {
        self::ensureKernelShutdown();
    }
}
