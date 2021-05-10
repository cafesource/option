<?php

use Cafesource\Option\Facades\Option;


if ( !function_exists('option') ) {
    /**
     * @return Option
     */
    function option() : Option
    {
        return app('cafesource.option');
    }
}