<?php

namespace Cafesource\Option;

use Cafesource\Foundation\Facades\Cafesource;
use Cafesource\Option\Repositories\Option as OptionRepository;

class Option
{
    /**
     * @var null
     */
    protected $config;

    /**
     * @var Manager
     */
    protected static $manager;

    public function __construct( $config )
    {
        $this->config = $config;

        self::$manager = new Manager($config);
    }

    /**
     * @return Manager
     */
    public static function manager()
    {
        return self::$manager;
    }

    /**
     * @param $method
     * @param $params
     *
     * @return false|mixed
     */
    public function __call( $method, $params )
    {
        if ( method_exists(self::manager(), $method) )
            return self::manager()->$method(...$params);

        return call_user_func_array([self::manager()->model(), $method], $params);
    }

    /**
     * @param $method
     * @param $params
     *
     * @return false|mixed
     */
    public static function __callStatic( $method, $params )
    {
        if ( method_exists(self::manager(), $method) )
            return self::manager()->$method(...$params);

        /**
         * Call to the option method
         */
        return call_user_func_array([self::manager()->model(), $method], $params);
    }
}
