<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    public $timestamps = false;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function activeFields()
    {
        return [
            'id' => request('id'),
            'name' => request('name'),
        ];
    }

    public function activeFieldsArrayAttributes($attributes)
    {
        return [
            'id' => $attributes['id'],
            'name' => $attributes['name'],
        ];
    }

    public function validationRules()
    {
        return [
            'id' => 'required|integer',
            'name' => 'required|string',
        ];
    }
}
