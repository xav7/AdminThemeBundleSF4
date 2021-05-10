<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Controller;

use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class SidebarController
{
    private Environment              $twig;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(Environment $twig, EventDispatcherInterface $eventDispatcher)
    {
        $this->twig            = $twig;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Block used in macro avanzu_sidebar_user
     */
    public function userPanelAction(): Response
    {
        if (!$this->eventDispatcher->hasListeners(ShowUserEvent::class)) {
            return new Response();
        }

        $userEvent = new ShowUserEvent();

        $this->eventDispatcher->dispatch($userEvent);

        $content = $this->twig->render(
            '@AvanzuAdminTheme/Sidebar/user-panel.html.twig',
            [
                'user' => $userEvent->getUser(),
            ]
        );

        return new Response($content);
    }

    public function searchFormAction(): Response
    {
        return new Response($this->twig->render('@AvanzuAdminTheme/Sidebar/search-form.html.twig'));
    }

    public function menuAction(Request $request): Response
    {
        if (!$this->eventDispatcher->hasListeners(SidebarMenuEvent::class)) {
            return new Response();
        }

        $event = new SidebarMenuEvent($request);

        $this->eventDispatcher->dispatch($event);

        $content = $this->twig->render(
            '@AvanzuAdminTheme/Sidebar/menu.html.twig',
            [
                'menu' => $event->getItems(),
            ]
        );

        return new Response($content);
    }
}
