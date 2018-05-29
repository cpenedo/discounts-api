<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\OrderRepository;

class Discount extends Model
{
    protected $table = 'discount';
    public $timestamps = false;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_has_discount', 'discount_id', 'order_id');
    }

    public function activeFields()
    {
        return [
            'name' => request('name'),
        	'description' => request('description'),
            'minimum_customer_revenue' => request('minimum_customer_revenue'),
            'total_order_discount_percent' => request('total_order_discount_percent'),
            'category_id' => request('category_id'),
            'multiple_products_same_category' => request('multiple_products_same_category'),
            'free_category_products' => request('free_category_products'),
            'minimum_quantity_same_category' => request('minimum_quantity_same_category'),
            'cheapest_product_discount_percent' => request('cheapest_product_discount_percent'),
        ];
    }

    public function validationRules()
    {
        return [
			'name' => 'required|string',
        	'description' => 'required|string',
            'minimum_customer_revenue' => 'nullable|numeric',
            'total_order_discount_percent' => 'nullable|numeric',
            'category_id' => 'nullable|integer|exists:category,id',
            'multiple_products_same_category' => 'nullable|integer',
            'free_category_products' => 'nullable|integer',
            'minimum_quantity_same_category' => 'nullable|integer',
            'cheapest_product_discount_percent' => 'nullable|numeric',
        ];
    }

    public static function checkDiscount(Order $order)
    {
    	$discounts = self::all();
    	$message = [];

    	foreach ($discounts as $discount) {
    		if($discount->minimum_customer_revenue) {
    			$message[] = $discount->totalDiscount($order);
    		} elseif ($discount->multiple_products_same_category) {
    			$message[] = $discount->freeProducts($order);
    		} elseif ($discount->cheapest_product_discount_percent) {
    			$message[] = $discount->cheapestProductDiscount($order);
    		}
    	}

    	return $message;
    }

    protected function totalDiscount(Order $order)
    {
    	$customer = $order->customer;

    	if($customer->revenue >= $this->minimum_customer_revenue) {
    		
            $this->orders()->attach($order->id);

    		return [
	    		'name' => $this->name,
                'discount-value' => self::calculateDiscount($order->total, $this->total_order_discount_percent),
    		];
    	}

    	return false;
    }

    protected function freeProducts(Order $order)
    {
        $message = [];
        $categoryItems = OrderRepository::getOrderItems($order->id, $this->category_id)->get();

        foreach ($categoryItems as $item) {

            $freeProducts = 0;
            $quantity = $item->quantity;

            if($quantity >= $this->multiple_products_same_category) {

                while($quantity >= $this->multiple_products_same_category) {
                    $freeProducts += $this->free_category_products;
                    $quantity -= $this->multiple_products_same_category;
                }

                $message[] = [
                    'name' => $this->name,
                    'product' => $item->code,
                    'free-products' => $freeProducts,
                ];
            }
        }

        if(!empty($message)) {
            $this->orders()->attach($order->id);
            return $message;
        }
        return false;
    }

    protected function cheapestProductDiscount(Order $order)
    {
        $categoryItemsNum = OrderRepository::getOrderItemsSum($order->id, $this->category_id)->first()->quantity_total;

    	if($categoryItemsNum >= $this->minimum_quantity_same_category) {

            $this->orders()->attach($order->id);

    		$cheapestProduct = OrderRepository::getOrderItems($order->id, $this->category_id)->first();

    		return [
    			'name' => $this->name,
    			'product' => $cheapestProduct->code,
                'discount-value' => self::calculateDiscount($cheapestProduct->price, $this->cheapest_product_discount_percent),
    		];
    	}
    	return false;
    }

    protected static function calculateDiscount($value, $percent)
    {
        return number_format($value * (floatval($percent) / 100), 2);
    }
}
