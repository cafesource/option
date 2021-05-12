<?php

use Cafesource\Option\Facades\Option;


if ( !function_exists('option') ) {
    /**
     * @return Option
     */
    function option()
    {
        return app('cafesource.option');
    }
}
