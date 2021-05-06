<?php

namespace Cafesource\Option;

use Cafesource\Foundation\Facades\Cafesource;
use Cafesource\Option\Repositories\Option as OptionRepository;
use Illuminate\Contracts\Foundation\Application;

class Manager
{
    protected $option;
    protected $repository = null;
    protected $autoload   = null;

    public function __construct( $config )
    {
        $this->option     = app($config[ 'option' ][ 'model' ]);
        $this->repository = new OptionRepository($this->option);
        $this->autoload   = Cafesource::autoload('options');

        $this->autoload();
    }

    /**
     * @return Application|mixed
     */
    public function model()
    {
        return $this->option;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has( $key ) : bool
    {
        if ( $this->repository->exists($key) )
            return true;

        return false;
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function first( $key, $default = null )
    {
        $autoload = $this->autoload;
        if ( $autoload->has($key) )
            return $autoload->get($key);

        $option = $this->repository->findByKey($key);
        if ( $option )
            $autoload->add($key, $option->getAttribute('value'));


        return $autoload->get($key, $default);
    }

    /**
     * @param string|array $key
     *
     * @return mixed
     */
    public function get( $key )
    {
        if ( is_array($key) )
            return $this->repository->getKeys($key);

        return $this->repository->get($key);
    }

    /**
     * @param string|int $key
     * @param mixed      $value
     * @param mixed      $option
     *
     * @return mixed
     */
    public function add( $key, $value = null, $option = null )
    {
        return $this->repository->add($key, $value, $option);
    }

    /**
     * @param $options
     *
     * @return mixed
     */
    public function insert( $options )
    {
        return $this->repository->insert($options);
    }

    /**
     * @param      $key
     * @param null $value
     * @param null $option
     *
     * @return mixed
     */
    public function update( $key, $value = null, $option = null )
    {
        $data = ['value' => $value, 'option' => $option];

        if ( is_array($value) )
            $data = $value;

        return $this->repository->update($key, $data);
    }

    /**
     * @param      $key
     * @param      $value
     * @param null $option
     *
     * @return mixed
     */
    public function updateOrAdd( $key, $value, $option = null )
    {
        $getOption = $this->repository->findByKey($key);

        if ( $getOption ) {
            $value = ['value' => $value];

            if ( !is_null($option) )
                $value[ 'option' ] = $option;

            $getOption->update($value);

            return $getOption;
        }

        return $this->repository->add($key, $value, $option);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function remove( $key )
    {
        if ( is_array($key) )
            return $this->repository->destroy($key);

        return $this->repository->remove($key);
    }

    /**
     * @param string $key
     */
    public function autoload( string $key = 'autoload' )
    {
        $options = $this->repository->autoload($key);

        foreach ( $options as $option ) {
            $this->autoload->add($option[ 'key' ], $option[ 'value' ]);
        }
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
    public function addFilter( $key, callable $callable, $arguments = 1, $priority = 10 )
    {
        $this->autoload->addFilter($key, $callable, $arguments, $priority);
    }
}