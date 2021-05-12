<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Model;

use function array_search;

class MenuItemModel implements MenuItemInterface
{
    private string             $identifier;

    private string             $label;

    private string             $route;

    private array              $routeArgs;

    private bool               $isActive = false;

    private array              $children = [];

    private string             $icon;

    private string             $badge;

    private string             $badgeColor;

    private ?MenuItemInterface $parent   = null;

    private array              $options;

    public function __construct(
        string $id,
        string $label,
        string $route,
        array $routeArgs = [],
        string $icon = '',
        array $options = [],
        string $badge = '',
        string $badgeColor = 'green'
    ) {
        $this->badge      = $badge;
        $this->icon       = $icon;
        $this->identifier = $id;
        $this->label      = $label;
        $this->route      = $route;
        $this->routeArgs  = $routeArgs;
        $this->badgeColor = $badgeColor;
        $this->options    = $options;
    }

    public function getBadge(): string
    {
        return $this->badge;
    }

    public function setBadge(string $badge): MenuItemModel
    {
        $this->badge = $badge;

        return $this;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function setChildren(array $children): void
    {
        $this->children = $children;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): MenuItemModel
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): MenuItemModel
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): MenuItemModel
    {
        if ($this->hasParent()) {
            /** @var MenuItemModel $parent */
            $parent = $this->getParent();

            $parent->setIsActive($isActive);
        }

        $this->isActive = $isActive;

        return $this;
    }

    public function hasParent(): bool
    {
        return $this->parent instanceof MenuItemInterface;
    }

    public function getParent(): ?MenuItemInterface
    {
        return $this->parent;
    }

    public function setParent(MenuItemInterface $parent = null): MenuItemModel
    {
        $this->parent = $parent;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): MenuItemModel
    {
        $this->label = $label;

        return $this;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): MenuItemModel
    {
        $this->route = $route;

        return $this;
    }

    public function getRouteArgs(): array
    {
        return $this->routeArgs;
    }

    public function setRouteArgs(array $routeArgs): MenuItemModel
    {
        $this->routeArgs = $routeArgs;

        return $this;
    }

    public function hasChildren(): bool
    {
        return count($this->children) > 0;
    }

    public function addChild(MenuItemInterface $child): MenuItemModel
    {
        $child->setParent($this);
        $this->children[] = $child;

        return $this;
    }

    public function removeChild(MenuItemInterface $child): MenuItemModel
    {
        $key = array_search($child, $this->children, true);

        if (false !== $key) {
            unset($this->children[$key]);
        }

        return $this;
    }

    public function getBadgeColor(): string
    {
        return $this->badgeColor;
    }

    public function setBadgeColor(string $badgeColor): MenuItemModel
    {
        $this->badgeColor = $badgeColor;

        return $this;
    }

    public function getActiveChild(): ?MenuItemInterface
    {
        foreach ($this->children as $child) {
            if ($child->isActive()) {
                return $child;
            }
        }

        return null;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
