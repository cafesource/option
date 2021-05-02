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

    public function __toString()
    {
        return $this->getAttribute('value');
    }
}
