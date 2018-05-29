<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';
    public $timestamps = false;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function activeFields($attributes)
    {
        return [
            'quantity' => $attributes['quantity'],
            'unit_price' => $attributes['unit-price'],
            'total' => $attributes['total'],
            'order_id' => $attributes['order-id'],
            // 'product_id' => $attributes['product-id'],
            'product_id' => Product::where('code', $attributes['product-id'])->first()->id,
        ];
    }

    public function validationRules()
    {
        return [
            'quantity' => 'required|integer',
            'unit-price' => 'required|numeric',
            'total' => 'required|numeric',
            'order-id' => 'required|integer|exists:order,id',
            'product-id' => 'required|string|exists:product,code',
        ];
    }
}
