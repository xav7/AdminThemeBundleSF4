<?php
/**
 * DependencyResolverInterface.php
 * publisher
 * Date: 18.04.14
 */

namespace Avanzu\AdminThemeBundle\Util;

interface DependencyResolverInterface
{
    public function register(mixed $items): DependencyResolverInterface;

    public function resolveAll(): array;
}
