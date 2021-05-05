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
}
