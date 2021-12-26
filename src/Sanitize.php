<?php

namespace Cafesource\Option;

use function PHPUnit\Framework\isJson;

class Sanitize
{
    /**
     * The Option value for sanitizing
     *
     * @var mixed $value
     */
    protected $value;

    /**
     * The option type
     *
     * @var mixed|null $type
     */
    protected $type = null;

    public function __construct( $value, $type = null )
    {
        $this->value = $value;
        $this->type  = $type;
    }

    /**
     * The option value with type
     *
     * @param $value
     * @param $type
     *
     * @return Sanitize
     */
    public static function value( $value, $type = null ) : Sanitize
    {
        return new self($value, $type);
    }

    /**
     * Set the type
     *
     * @param $name
     *
     * @return $this
     */
    public function type( $name ) : Sanitize
    {
        $this->type = $name;
        return $this;
    }

    /**
     * The option type
     *
     * @return string
     */
    public function getType() : string
    {
        return gettype($this->value);
    }

    /**
     * Convert to string value for saving in database
     *
     * @return string
     */
    public function getString() : string
    {
        $value = $this->value;
        if ( in_array($this->getType(), ['array', 'object']) )
            $value = serialize($value);

        return (string)$value;
    }

    /**
     * The original value
     *
     * @return bool|mixed
     */
    public function getValue()
    {
        $type  = $this->type ?? $this->getType();
        $value = $this->value;
        if ( in_array($type, ['object', 'array']) )
            return unserialize($value);

        if ( $type == 'boolean' )
            return (bool)$value;

        if ( $type == 'double' )
            return (double)$value;

        if ( $type == 'integer' )
            return (int)$value;

        return $value;
    }
}