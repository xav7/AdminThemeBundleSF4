<?php
/** @noinspection ClassMockingCorrectnessInspection */

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Tests\Controller;

use Avanzu\AdminThemeBundle\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @group functional
 */
class DefaultControllerTest extends AbstractWebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function test_routes_is_successful(string $url): void
    {
        $this->client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
    }

    public function urlProvider(): iterable
    {
        yield ['/demo-admin/form-demo/'];
    }
}
