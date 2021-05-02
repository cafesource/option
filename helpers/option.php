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