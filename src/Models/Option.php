<?php


namespace Cafesource\Option\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'option'
    ];

    /**
     * Return the value column string
     */
    public function __toString()
    {
        return (string) $this->getAttribute('value');
    }

    public function isNull()
    {
        return is_null($this->getAttribute('value'));
    }
}
