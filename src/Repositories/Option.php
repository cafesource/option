<?php

namespace Cafesource\Option\Repositories;

use Illuminate\Database\Eloquent\Model;

class Option
{
    protected Model $option;

    public function __construct( Model $option )
    {
        $this->option = $option;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function exists( $key )
    {
        return $this->option->where('key', $key)->exists();
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function findById( int $id )
    {
        return $this->option->where('id', $id)->first();
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function findByKey( string $key )
    {
        return $this->option->where('key', $key)->first();
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get( string $key )
    {
        return $this->option->where('key', $key)->get();
    }

    /**
     * The autoload options
     *
     * @return mixed
     */
    public function autoload( $key = 'autoload' )
    {
        return $this->option->where('option', $key)->get()->toArray();
    }

    /**
     * @param array $keys
     *
     * @return mixed
     */
    public function getKeys( array $keys )
    {
        return $this->option->whereIn('key', $keys)->get();
    }

    /**
     * @param string      $key
     * @param string|null $value
     * @param string|null $option
     *
     * @return mixed
     */
    public function add( string $key, string $value = null, string $option = null )
    {
        return $this->option->create([
            'key'    => $key,
            'value'  => $value,
            'option' => $option
        ]);
    }

    /**
     * @param array $options
     *
     * @return mixed
     */
    public function insert( array $options )
    {
        return $this->option->insert($options);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function update( $key, $value )
    {
        return $this->option->where('key', $key)->update($value);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function remove( string $key )
    {
        return $this->option->where('key', $key)->delete();
    }

    /**
     * @param array $keys
     *
     * @return mixed
     */
    public function destroy( array $keys )
    {
        return $this->option->whereIn('key', $keys)->delete();
    }
}
