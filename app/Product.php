<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    public $timestamps = false;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

   public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function activeFields()
    {
        return [
            'code' => request('id'),
            'description' => request('description'),
            'price' => request('price'),
            'category_id' => request('category'),
        ];
    }

    public function activeFieldsArrayAttributes($attributes)
    {
        return [
            'code' => $attributes['id'],
            'description' => $attributes['description'],
            'price' => $attributes['price'],
            'category_id' => $attributes['category'],
        ];
    }

    public function validationRules()
    {
        return [
            'id' => 'required|string|unique:product',
        	'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|integer|exists:category,id',
        ];
    }
}
