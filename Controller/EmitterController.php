<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Controller;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Twig\Environment;

use function is_callable;

class EmitterController
{
    private Environment              $twig;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(Environment $twig, EventDispatcherInterface $eventDispatcher)
    {
        $this->twig            = $twig;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function hasListener(string $eventName): bool
    {
        return $this->eventDispatcher->hasListeners($eventName);
    }

    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    /**
     * Will look for a method of the format "on<CamelizedEventName>" and call it with the event as argument.
     *
     *
     * Then it will dispatch the event as normal via the event dispatcher.
     */
    public function triggerMethod(string $eventName, Event $event): Event
    {
        $method = sprintf('on%s', Container::camelize(str_replace('.', '_', $eventName)));

        if (is_callable([$this, $method])) {
            $this->$method($event);
        }

        if ($event->isPropagationStopped()) {
            return $event;
        }

        $this->eventDispatcher->dispatch($event, $eventName);

        return $event;
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }
}
