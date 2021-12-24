<?php

return [
    /**
     * Autoload keys
     *
     * Loaded the options in laravel boot
     */
    'autoload' => [
        'keys' => ['autoload']
    ],

    'option' => [
        'driver' => 'eloquent',
        'model'  => \Cafesource\Option\Models\Option::class
    ]
];
