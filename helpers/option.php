<?php

use Cafesource\Option\Facades\Option;


if ( !function_exists('option') ) {
    /**
     * @return mixed
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
