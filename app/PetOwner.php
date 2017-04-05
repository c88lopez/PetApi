<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PetOwner
 *
 * @package App
 *
 * @property string name
 * @property string last_name
 * @property string birth_date
 */
class PetOwner extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function setIdAttribute($value)
    {
        $this->attributes['id'] = $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = $value;
    }

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = $value;
    }

    public function pets()
    {
        return $this->hasMany('App\Pet');
    }

    public function create(array $parameters)
    {
        $this->setNameAttribute($parameters['name']);
        $this->setLastNameAttribute($parameters['last_name']);
        $this->setBirthDateAttribute($parameters['birth_date']);

        $this->save();

        return $this->id;
    }

    public function modify(array $parameters)
    {
        $petOwner = self::find((int)$parameters['id']);

        $petOwner->name       = $parameters['name'];
        $petOwner->last_name  = $parameters['last_name'];
        $petOwner->birth_date = $parameters['birth_date'];

        return $petOwner->save();
    }
}
