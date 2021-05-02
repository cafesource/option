<?php

namespace Cafesource\Option;

use Cafesource\Option\Models\Option as OptionModel;

class Option
{
    protected $key = null;
    /**
     * @var mixed $data
     */
    protected $option;
    protected $default = null;

    public function __construct( $key, OptionModel $option, $default = null )
    {
        $this->key     = $key;
        $this->option  = $option;
        $this->default = $default;
    }

    public function __get( $name )
    {
        return $this->option->getAttribute($name);
    }

    public function __toString()
    {
        return $this->option->value;
    }

    public function toString() : string
    {
        return (string)$this->option->getAttribute('value');
    }

    public function toSerialize() : string
    {
        return serialize($this->option);
    }

    public function toJson($options = 0) : string
    {
        return $this->option->toJson($options);
    }

    public function toArray() : array
    {
        return $this->option->toArray();
    }

    public function autoload( $key = 'autoload' )
    {
        $options = $this->repository->autoload($key);
        $this->manage($options);
    }

    protected function manage( $data, $value = null )
    {
        $manager = new Manager($data, $value);

        $this->autoload->set($data, $manager);
        return $manager;
    }
}