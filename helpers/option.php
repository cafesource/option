<?php

use Cafesource\Option\Facades\Option;


if ( !function_exists('option') ) {
    /**
     * @param $key
     *
     * @return Option
     */
    function option()
    {
        return app('cafesource.option');
    }
}

if( !function_exists('getOption') ) {
    /**
     * @param string|int $key
     * @param $default 
     * 
     * @return mixed
     */
    function getOption($key, $default = null)
    {
        return option()->first($key, $default);
    }
}