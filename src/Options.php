<?php

namespace Cafesource\Option;

use Cafesource\Option\Repositories\Option as OptionRepository;

use Cafesource\Foundation\Facades\Cafesource;

class Options
{
    protected $config     = null;
    protected $repository = null;
    protected $autoload   = null;

    public function __construct( $config )
    {
        $this->config     = $config;
        $this->repository = new OptionRepository();
        $this->autoload   = Cafesource::autoload('options');

        $this->autoload();
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
        if ( $this->autoload->has($key) )
            return $this->autoload->get($key);

        $option = $this->repository->findByKey($key);
        if ( $option ) {
            $option = new Option($option->key, $option, $default);
            $this->autoload->set($key, $option);

            return $option;
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
     * TODO OPTION: UPDATE OR CREATE OPTION
     */
    public function updateOrAdd( $key, $value, $option = null )
    {
        $getOption = $this->repository->findByKey($key);

        if ( $getOption ) {
            $value = ['value' => $value];

            if ( !is_null($option) )
                $value[ 'option' ] = $option;

            return $getOption->update($value);
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
    public function autoload( $key = 'autoload' )
    {
        $options = $this->repository->autoload($key);

        foreach ( $options as $option ) {
            $this->autoload->add($option->key, $option);
        }
    }
}
