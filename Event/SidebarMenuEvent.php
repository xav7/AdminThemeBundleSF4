<?php
/**
 * SidebarMenuEvent.php
 * avanzu-admin
 * Date: 23.02.14
 */

namespace Avanzu\AdminThemeBundle\Event;

use Avanzu\AdminThemeBundle\Model\MenuItemInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SidebarMenuEvent
 *
 * @package Avanzu\AdminThemeBundle\Event
 */
class SidebarMenuEvent extends ThemeEvent
{
    protected array    $menuRootItems = [];

    protected ?Request $request;

    public function __construct($request = null)
    {
        $this->request = $request;
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function getItems(): array
    {
        return $this->menuRootItems;
    }

    /**
     * @param MenuItemInterface|MenuItem $item
     */
    public function addItem($item): void
    {
        $this->menuRootItems[$item->getIdentifier()] = $item;
    }

    /**
     * @param $id
     *
     * @return null
     */
    public function getRootItem($id)
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
