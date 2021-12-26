<?php

use Cafesource\Option\Facades\Option;
use Illuminate\Contracts\Foundation\Application;


if ( !function_exists('option') ) {
    /**
     * @param array|string $key
     * @param mixed $default
     *
     * @return \Cafesource\Option\Option|Application|mixed
     */
    function option( $key = null, $default = null )
    {
        if ( is_null($key) )
            return app('cafesource.option');

        if ( is_array($key) )
            return app('cafesource.option')->get($key);

        return app('cafesource.option')->first($key, $default);
    }
}
