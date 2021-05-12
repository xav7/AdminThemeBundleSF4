<?php

declare(strict_types=1);

namespace Avanzu\AdminThemeBundle\Model;

interface MenuItemInterface
{
    public function getIdentifier(): string;

    public function getLabel(): string;

    public function getRoute(): string;

    public function isActive(): bool;

    public function setIsActive(bool $isActive): MenuItemInterface;

    public function hasChildren();

    /**
     * @return list<MenuItemInterface>
     */
    public function getChildren(): array;

    public function addChild(MenuItemInterface $child): MenuItemInterface;

    public function removeChild(MenuItemInterface $child): MenuItemInterface;

    /**
     * @return mixed
     */
    public function getIcon();

    /**
     * @return mixed
     */
    public function getBadge();

    public function getBadgeColor(): string;

    public function getParent(): MenuItemInterface;

    public function hasParent(): bool;

    public function setParent(MenuItemInterface $parent = null): MenuItemInterface;

    public function getActiveChild(): ?MenuItemInterface;

    public function getOptions(): array;
}
