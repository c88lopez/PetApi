<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetType extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    const DOG  = 1;
    const CAT  = 2;
    const FISH = 3;
}
