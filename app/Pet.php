<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pet
 *
 * @package App
 *
 * @property integer id
 * @property integer pet_type_id
 * @property integer pet_owner_id
 * @property string  name
 * @property string  gender
 * @property string  birth_date
 */
class Pet extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function setIdAttribute($value)
    {
        $this->attributes['id'] = (int)$value;
    }

    public function setPetTypeIdAttribute($value)
    {
        $this->attributes['pet_type_id'] = (int)$value;
    }

    public function setPetOwnerIdAttribute($value)
    {
        $this->attributes['pet_owner_id'] = (int)$value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function setGenderAttribute($value)
    {
        $this->attributes['gender'] = $value;
    }

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = $value;
    }

    public function create(array $parameters)
    {
        $this->setPetTypeIdAttribute($parameters['pet_type_id']);
        $this->setPetOwnerIdAttribute($parameters['pet_owner_id']);
        $this->setNameAttribute($parameters['name']);
        $this->setGenderAttribute($parameters['gender']);
        $this->setBirthDateAttribute($parameters['birth_date']);

        $this->save();

        return $this->id;
    }
}
