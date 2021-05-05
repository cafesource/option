<?php


namespace Cafesource\Option\Facades;

use Cafesource\Option\Option as OptionModule;
use Illuminate\Support\Facades\Facade;

/**
 * Class Option
 *
 * @method static bool has(string $key)
 * @method static \Cafesource\Option\Models\Option first(string $key, $default = null)
 * @method static mixed get(mixed $key)
 * @method static mixed add(string $key, mixed $value = null, string $option = null)
 * @method static mixed update(string $key, mixed $value = null, string $option = null)
 * @method static mixed updateOrAdd(string $key, mixed $value = null, string $option = null)
 * @method static bool remove(mixed $key)
 * @method static bool filter(string $key, $callback)
 * @method static bool addFilter(string $key, callable $callback, int $arguments = 1, int $priority = 20)
 *
 * @method static void autoload()
 *
 * @package Cafesource\Option\Facades
 */
class Option extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cafesource.option';
    }
}
