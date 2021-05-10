<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Event;

use Avanzu\AdminThemeBundle\Model\MenuItemInterface;
use Symfony\Component\HttpFoundation\Request;

class SidebarMenuEvent extends ThemeEvent
{
    private array   $menuRootItems = [];

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getItems(): array
    {
        return $this->menuRootItems;
    }

    public function addItem(MenuItemInterface $item): void
    {
        $this->menuRootItems[$item->getIdentifier()] = $item;
    }

    public function getRootItem(string $id): ?MenuItemInterface
    {
        return $this->menuRootItems[$id] ?? null;
    }

    public function getActive(): ?MenuItemInterface
    {
        foreach ($this->getItems() as $item) {
            /** @var MenuItemInterface $item */
            if ($item->isActive()) {
                return $item;
            }
        }

        return null;
    }
}
