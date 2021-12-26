<?php

namespace Cafesource\Option;

use Cafesource\Foundation\Autoload;
use Cafesource\Foundation\Facades\Cafesource;
use Cafesource\Option\Repositories\Option as Repository;
use Illuminate\Contracts\Foundation\Application;

class Manager
{
    protected array     $config   = [];
    protected ?Autoload $autoload = null;

    public function __construct( $config )
    {
        $this->config   = $config;
        $this->autoload = Cafesource::autoload('options');

        $this->boot();
    }

    /**
     * Boot the option
     *
     * @return void
     */
    public function boot()
    {
        $this->runAutoload($this->config[ 'autoload' ][ 'keys' ]);
    }

    /**
     * @return Application|mixed
     */
    public function model()
    {
        return app($this->config[ 'option' ][ 'model' ]);
    }

    /**
     * The option repository
     *
     * @return Repository
     */
    public function repository() : Repository
    {
        return new Repository($this->model());
    }

    /**
     * Converting the option value to string for saving in database
     *
     * @param $value
     * @param $format
     *
     * @return Sanitize
     */
    public function sanitize( $value, $format = null ) : Sanitize
    {
        return new Sanitize($value, $format);
    }

    /**
     * @param $optionKey
     * @param $callback
     *
     * @return void
     */
    public function filter( $optionKey, $callback )
    {
        $this->autoload->filter($optionKey, $callback);
    }

    /**
     * @param          $key
     * @param callable $callable
     * @param int      $arguments
     * @param int      $priority
     *
     * @return void
     */
    public function addFilter( $key, callable $callable, int $arguments = 1, int $priority = 10 )
    {
        $this->autoload->addFilter($key, $callable, $arguments, $priority);
    }

    /**
     * Checking the option exists
     *
     * @param string $key
     *
     * @return bool
     */
    public function exists( string $key ) : bool
    {
        if ( $this->repository()->exists($key) )
            return true;

        return false;
    }

    /**
     * Checking the option
     *
     * @param string $key
     *
     * @return bool
     */
    public function has( string $key ) : bool
    {
        return $this->exists($key);
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function first( $key, $default = null )
    {
        if ( $this->autoload->has($key) )
            return $this->autoload->get($key, $default);

        $option = $this->repository()->findByKey($key);
        if ( $option ) {
            return $this->autoload(
                $key,
                $this->sanitize($option->value, $option->format)->getValue()
            )->get($key, $default);
        }

        return $default;
    }

    /**
     * @param string|array $key
     *
     * @return mixed
     */
    public function get( $key )
    {
        if ( is_array($key) )
            return $this->repository()->getKeys($key);

        return $this->repository()->get($key);
    }

    /**
     * @param string|int $key
     * @param mixed      $value
     * @param mixed      $option
     *
     * @return mixed
     */
    public function add( $key, $value = null, $option = null, string $format = null )
    {
        $value  = $this->sanitize($value, $format)->getString();
        $format = $this->sanitize($value, $format)->getFormat();

        return $this->repository()->add($key, $value, $option, $format);
    }

    /**
     * @param $options
     *
     * @return mixed
     */
    public function insert( $options )
    {
        return $this->repository()->insert($options);
    }

    /**
     * @param      $key
     * @param null $value
     * @param null $option
     * @param null $format
     *
     * @return mixed
     */
    public function update( $key, $value = null, $option = null, $format = null )
    {
        $value  = $this->sanitize($value, $format)->getString();
        $format = $this->sanitize($value, $format)->getFormat();

        return $this->repository()->update($key, [
            'value'  => $value,
            'option' => $option,
            'format' => $format
        ]);
    }

    /**
     * @param             $key
     * @param             $value
     * @param string|null $option
     * @param string|null $format
     *
     * @return mixed
     */
    public function updateOrAdd( $key, $value, string $option = null, string $format = null )
    {
        $getOption = $this->repository()->findByKey($key);
        if ( !$getOption )
            return $this->repository()->add($key, $value, $option, $format);

        return $this->update($key, $value, $option, $format);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function remove( $key )
    {
        if ( is_array($key) )
            return $this->repository()->destroy($key);

        return $this->repository()->remove($key);
    }

    /**
     * @param array $key
     */
    public function runAutoload( array $key = ['autoload'] )
    {
        foreach ( $this->repository()->autoload($key) as $option ) {
            $this->autoload->add(
                $option->key,
                $this->sanitize($option->value, $option->format)->getValue()
            );
        }
    }

    /**
     * @param $key
     * @param $value
     *
     * @return Autoload
     */
    public function autoload( $key, $value ) : Autoload
    {
        $this->autoload->add($key, $value);
        return $this->autoload;
    }
}