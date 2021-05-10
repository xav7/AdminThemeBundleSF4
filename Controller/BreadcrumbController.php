<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Controller;

use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Avanzu\AdminThemeBundle\Event\ThemeEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Controller to handle breadcrumb display inside the layout
 */
class BreadcrumbController
{
    private Environment              $twig;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(Environment $twig, EventDispatcherInterface $eventDispatcher)
    {
        $this->twig            = $twig;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Controller Reference action to be called inside the layout.
     *
     * Triggers the {@link ThemeEvents::THEME_BREADCRUMB} to receive the currently active menu chain.
     *
     * If there are no listeners attached for this event, the return value is an empty response.
     */
    public function breadcrumbAction(Request $request, string $title = ''): Response
    {
        if (!$this->eventDispatcher->hasListeners(ThemeEvents::THEME_BREADCRUMB)) {
            return new Response();
        }

        $sidebarMenuEvent = new SidebarMenuEvent($request);
        $active           = $sidebarMenuEvent->getActive();
        $list             = [];

        $this->eventDispatcher->dispatch($sidebarMenuEvent, ThemeEvents::THEME_BREADCRUMB);

        if ($active) {
            $list[] = $active;
            while (null !== ($item = $active->getActiveChild())) {
                $list[] = $item;
                $active = $item;
            }
        }

        $html = $this->twig->render(
            '@AvanzuAdminTheme/Breadcrumb/breadcrumb.html.twig',
            [
                'active' => $list,
                'title'  => $title,
            ]
        );

        return new Response($html);
    }
}
