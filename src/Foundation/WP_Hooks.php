<?php

declare(strict_types=1);

namespace Vihersalo\Core\Foundation;

// phpcs:disable
class WP_Hooks {
    /**
     * The array of actions registered with WordPress.
     * @var      array    $actions    The actions registered with WordPress to fire when the theme loads.
     */
    protected $actions = [];

    /**
     * The array of remove actions registered with WordPress.
     * @var      array    $remove_actions    The actions registered with WordPress to remove when the theme loads.
     */
    protected $removeActions = [];

    /**
     * The array of filters registered with WordPress.
     * @var      array    $filters    The filters registered with WordPress to fire when the theme loads.
     */
    protected $filters = [];

    /**
     * The array of remove filters registered with WordPress.
     * @var      array    $remove_filters    The filters registered with WordPress to remove when the theme loads.
     */
    protected $removeFilters = [];

    /**
     * Constructor for the class. Should not be called directly.
     * @return void
     */
    public function __construct() {
    }

    /**
     * Prevent cloning of the instance of the class
     * @return   void
     */
    public function __clone() {
    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     * @param string $hook The name of the WordPress action that is being registered.
     * @param object|null $component A reference to the instance of the object on which the action is defined.
     * @param string $callback The name of the function definition on the $component.
     * @param int $priority Optional. The priority at which the function should be fired. Default is 10.
     * @param int $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function addAction($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Remove an action from the collection to be registered with WordPress.
     * @param string $hook The name of the WordPress action that is being removed.
     * @param callable|string|array $callback The name of the function definition on the $component.
     * @param int $priority Optional. The priority at which the function should be fired. Default is 10.
     * @return void
     */
    public function removeAction($hook, $callback, $priority = 10) {
        $this->removeActions = $this->add($this->removeActions, $hook, null, $callback, $priority, 0);
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     * @param string $hook The name of the WordPress filter that is being registered.
     * @param object|null $component A reference to the instance of the object on which the filter is defined.
     * @param string $callback The name of the function definition on the $component.
     * @param int $priority Optional. The priority at which the function should be fired. Default is 10.
     * @param int $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1
     */
    public function addFilter($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Remove a filter from the collection to be registered with WordPress.
     * @param string $hook The name of the WordPress filter that is being removed.
     * @param callable|string|array $callback The name of the function definition on the $component.
     * @param int $priority Optional. The priority at which the function should be fired. Default is 10.
     * @return void
     */
    public function removeFilter($hook, $callback, $priority = 10) {
        $this->removeFilters = $this->add($this->removeFilters, $hook, null, $callback, $priority, 0);
    }

    /**
     * A utility function that is used to register the actions and hooks into a single
     * collection.
     * @param array $hooks The collection of hooks that is being registered (that is, actions or filters).
     * @param string $hook The name of the WordPress filter that is being registered.
     * @param object|null $component A reference to the instance of the object on which the filter is defined.
     * @param string $callback The name of the function definition on the $component.
     * @param int $priority The priority at which the function should be fired.
     * @param int $accepted_args The number of arguments that should be passed to the $callback.
     * @return array The collection of actions and filters registered with WordPress.
     */
    private function add($hooks, $hook, $component, $callback, $priority = 10, $accepted_args = 0) {
        $hooks[] = [
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args,
        ];

        return $hooks;
    }

    /**
     * Register the filters and actions with WordPress.
     * @return void
     */
    public function run() {
        foreach ($this->removeFilters as $hook) {
            \remove_filter(
                $hook['hook'],
                null !== $hook['component'] ? [$hook['component'], $hook['callback']] : $hook['callback'],
                $hook['priority']
            );
        }

        foreach ($this->removeActions as $hook) {
            \remove_action(
                $hook['hook'],
                null !== $hook['component'] ? [$hook['component'], $hook['callback']] : $hook['callback'],
                $hook['priority']
            );
        }

        foreach ($this->filters as $hook) {
            \add_filter(
                $hook['hook'],
                null !== $hook['component'] ? [$hook['component'], $hook['callback']] : $hook['callback'],
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        foreach ($this->actions as $hook) {
            \add_action(
                $hook['hook'],
                null !== $hook['component'] ? [$hook['component'], $hook['callback']] : $hook['callback'],
                $hook['priority'],
                $hook['accepted_args']
            );
        }
    }
}
