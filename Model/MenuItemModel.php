<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Model;

use function array_search;

class MenuItemModel implements MenuItemInterface
{
    protected string $identifier;

    protected string $label;

    protected string $route;

    protected array  $routeArgs = [];

    protected bool   $isActive  = false;

    protected array  $children  = [];

    /**
     * @var mixed
     */
    protected $icon = false;

    /**
     * @var mixed
     */
    protected                    $badge      = false;

    protected string             $badgeColor = 'green';

    protected ?MenuItemInterface $parent     = null;

    private array                $options;

    public function __construct(
        string $id,
        string $label,
        string $route,
        array $routeArgs = [],
        $icon = false,
        $badge = false,
        string $badgeColor = 'green',
        array $options = []
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

    /**
     * @return mixed
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * @param mixed $badge
     */
    public function setBadge($badge): MenuItemModel
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

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon): MenuItemModel
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
