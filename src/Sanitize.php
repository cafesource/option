<?php

namespace Cafesource\Option;

class Sanitize
{
    /**
     * The Option value for sanitizing
     *
     * @var mixed $value
     */
    protected $value;

    /**
     * The option format
     *
     * @var mixed|null $format
     */
    protected $format;

    public function __construct( $value, $format = null )
    {
        $this->value  = $value;
        $this->format = $format;
    }

    /**
     * The option value with format
     *
     * @param $value
     * @param $format
     *
     * @return Sanitize
     */
    public static function value( $value, $format = null ) : Sanitize
    {
        return new self($value, $format);
    }

    /**
     * Set the format
     *
     * @param $name
     *
     * @return $this
     */
    public function format( $name ) : Sanitize
    {
        $this->format = $name;
        return $this;
    }

    /**
     * The option format
     *
     * @return string
     */
    public function getFormat() : string
    {
        if ( is_bool($this->value) )
            return 'bool';

        if ( is_float($this->value) )
            return 'float';

        if ( is_numeric($this->value) )
            return 'numeric';

        if ( is_array($this->value) )
            return 'array';

        if ( is_object($this->value) )
            return 'object';

        return 'string';
    }

    /**
     * Convert to string value for saving in database
     *
     * @return string
     */
    public function getString() : string
    {
        $value = $this->value;
        if ( is_array($value) || is_object($value) )
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
        $format = $this->format ?? $this->getFormat();
        $value  = $this->value;
        if ( in_array($format, ['object', 'array']) )
            return unserialize($value);

        if ( $format == 'bool' )
            return (bool)$value;

        if ( $format == 'float' )
            return (float)$value;

        if ( $format == 'numeric' )
            return (int)$value;

        return $value;
    }
}