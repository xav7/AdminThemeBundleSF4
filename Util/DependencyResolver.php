<?php
/**
 * DependencyResolver.php
 * publisher
 * Date: 18.04.14
 */

namespace Avanzu\AdminThemeBundle\Util;

/**
 * Class DependencyResolver
 *
 * @package Avanzu\AdminThemeBundle\Util
 */
class DependencyResolver implements DependencyResolverInterface
{
    protected array $queued     = [];

    protected array $registered = [];

    protected array $resolved   = [];

    protected array $unresolved = [];

    public function register($items): DependencyResolverInterface
    {
        $this->registered = $items;

        return $this;
    }

    public function resolveAll(): array
    {
        $this->failOnCircularDependencies();
        $this->resolve(array_keys($this->registered));

        return $this->queued;
    }

    protected function resolve($ids)
    {
        foreach ($ids as $id) {
            if (isset($this->resolved[$id])) {
                continue;
            } // already done
            if (!isset($this->registered[$id])) {
                continue;
            } // unregistered
            if (!$this->hasDependencies($id)) { // standalone
                $this->queued[]      = $this->registered[$id];
                $this->resolved[$id] = true;

                continue;
            }

            $deps = $this->unresolved($this->getDependencies($id));

            $this->resolve($deps);

            $deps = $this->unresolved($this->getDependencies($id));

            if (empty($deps)) {
                $this->queued[]      = $this->registered[$id];
                $this->resolved[$id] = true;

                continue;
            }
        }
    }

    protected function unresolved($deps): array
    {
        return array_diff($deps, array_keys($this->resolved));
    }

    protected function hasDependencies($id): bool
    {
        if (!isset($this->registered[$id])) {
            return false;
        }

        return !empty($this->registered[$id]['deps']);
    }

    /**
     * @return null
     */
    protected function getDependencies($id)
    {
        if (!$this->hasDependencies($id)) {
            return null;
        }

        return $this->registered[$id]['deps'];
    }

    protected function contains($needle, $haystackId): bool
    {
        $deps = $this->getDependencies($haystackId);
        if (!is_array($deps)) {
            return false;
        }

        return in_array($needle, $deps);
    }

    /**
     * @throws \RuntimeException
     */
    protected function failOnCircularDependencies(): void
    {
        $ids = array_keys($this->registered);

        foreach ($ids as $id) {
            if (!$this->hasDependencies($id)) {
                continue;
            }

            $dependencies = $this->getDependencies($id);

            foreach ($dependencies as $dep) {
                if ($this->contains($id, $dep)) {
                    throw new \RuntimeException(
                        sprintf(
                            'Circular dependency [%s] depends on [%s] which itself depends on [%s]',
                            $id,
                            $dep,
                            $id
                        )
                    );
                }
            }
        }
    }
}
