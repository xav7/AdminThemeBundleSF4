<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class DefaultController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Template()
     */
    public function indexAction(): Response
    {
        $html = $this->twig->render('@AvanzuAdminTheme/Default/index.html.twig');

        return new Response($html);
    }

    public function dashboardAction(): Response
    {
        $html = $this->twig->render('@AvanzuAdminTheme/Default/index.html.twig');

        return new Response($html);
    }

    public function uiGeneralAction(): Response
    {
        $html = $this->twig->render('@AvanzuAdminTheme/Default/index.html.twig');

        return new Response($html);
    }

    public function uiIconsAction(): Response
    {
        $html = $this->twig->render('@AvanzuAdminTheme/Default/index.html.twig');

        return new Response($html);
    }

    public function loginAction(): Response
    {
        $html = $this->twig->render('@AvanzuAdminTheme/Default/login.html.twig');

        return new Response($html);
    }
}
