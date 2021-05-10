<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Controller;

use Avanzu\AdminThemeBundle\Event\MessageListEvent;
use Avanzu\AdminThemeBundle\Event\NotificationListEvent;
use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Avanzu\AdminThemeBundle\Event\TaskListEvent;
use Avanzu\AdminThemeBundle\Event\ThemeEvents;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends EmitterController
{
    private const MAX_NOTIFICATIONS = 5;
    private const MAX_MESSAGES      = 5;
    private const MAX_TASKS         = 5;

    public function notificationsAction(int $max = self::MAX_NOTIFICATIONS): Response
    {
        if (!$this->getDispatcher()->hasListeners(NotificationListEvent::class)) {
            return new Response();
        }

        $listEvent = new NotificationListEvent();

        $this->getDispatcher()->dispatch($listEvent);

        $html = $this->getTwig()->render(
            '@AvanzuAdminTheme/Navbar/notifications.html.twig',
            [
                'notifications' => $listEvent->getNotifications(),
                'total'         => $listEvent->getTotal(),
            ]
        );

        return new Response($html);
    }

    public function messagesAction(int $max = self::MAX_MESSAGES): Response
    {
        if (!$this->getDispatcher()->hasListeners(MessageListEvent::class)) {
            return new Response();
        }

        $listEvent = new MessageListEvent();

        $this->getDispatcher()->dispatch($listEvent);

        $html = $this->getTwig()->render(
            '@AvanzuAdminTheme/Navbar/messages.html.twig',
            [
                'messages' => $listEvent->getMessages(),
                'total'    => $listEvent->getTotal(),
            ]
        );

        return new Response($html);
    }

    public function tasksAction(int $max = self::MAX_TASKS): Response
    {
        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_TASKS)) {
            return new Response();
        }

        /** @var TaskListEvent $listEvent */
        $listEvent = $this->triggerMethod(ThemeEvents::THEME_TASKS, new TaskListEvent($max));

        $html = $this->getTwig()->render(
            '@AvanzuAdminTheme/Navbar/tasks.html.twig',
            [
                'tasks' => $listEvent->getTasks(),
                'total' => $listEvent->getTotal(),
            ]
        );

        return new Response($html);
    }

    public function userAction(): Response
    {
        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_NAVBAR_USER)) {
            return new Response();
        }

        /** @var ShowUserEvent $userEvent */
        $userEvent = $this->triggerMethod(ThemeEvents::THEME_NAVBAR_USER, new ShowUserEvent());

        if (!$userEvent instanceof ShowUserEvent) {
            return new Response();
        }

        $html = $this->getTwig()->render(
            '@AvanzuAdminTheme/Navbar/user.html.twig',
            [
                'user'            => $userEvent->getUser(),
                'links'           => $userEvent->getLinks(),
                'showProfileLink' => $userEvent->isShowProfileLink(),
                'showLogoutLink'  => $userEvent->isShowLogoutLink(),
            ]
        );

        return new Response($html);
    }
}
