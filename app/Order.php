<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    public $timestamps = false;
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

   public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'order_has_discount', 'order_id', 'discount_id');
    }

   public function orderItemsCategory($category)
    {
        return $this->hasMany(OrderItem::class)
			->join('product', 'order_item.product_id', '=', 'product.id')
        	->where('category_id', '=', $category)
        	->orderBy('price', 'asc');
    }

    public function activeFields()
    {
        return [
            'id' => request('id'),
			'total' => request('total'),
            'customer_id' => request('customer-id'),
        ];
    }

    public function validationRules()
    {
        return [
            'id' => 'required|integer',
            'total' => 'required|numeric',
            'customer-id' => 'required|integer|exists:customer,id',
        ];
    }
}
