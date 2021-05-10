<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Controller;

use Avanzu\AdminThemeBundle\Form\FormDemoModelType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class DefaultController
{
    private Environment $twig;

    private Form        $form;

    public function __construct(Environment $twig, Form $form)
    {
        $this->twig = $twig;
        $this->form = $form;
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

    public function formAction(): Response
    {
        $form = $this->form->get(FormDemoModelType::class);
        $html = $this->twig->render(
            '@AvanzuAdminTheme/Default/form.html.twig',
            [
                'form' => $form->createView(),
            ]
        );

        return new Response($html);
    }

    public function loginAction(): Response
    {
        $html = $this->twig->render('@AvanzuAdminTheme/Default/login.html.twig');

        return new Response($html);
    }
}
