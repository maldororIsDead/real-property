<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class House
 * @package App\Models
 */
class House extends Model
{
    /**
     * @const integer
     */
    const PER_PAGE = 5;

    /**
     * @var string
     */
    protected $table = 'houses';

    /**
     * @var array
     */
    protected $guarded = [];
}
