<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class SecurityController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function loginAction(Request $request): Response
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }

        $html = $this->twig->render(
            '@AvanzuAdminTheme/Security/login.html.twig',
            [
                'last_username' => $session->get(Security::LAST_USERNAME),
                'error'         => $error,
            ]
        );

        return new Response($html);
    }
}
