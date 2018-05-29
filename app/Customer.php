<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    public $timestamps = false;
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function activeFields()
    {
        return [
        	'id' => request('id'),
			'name' => request('name'),
            'since' => request('since'),
            'revenue' => request('revenue')
        ];
    }

    public function activeFieldsArrayAttributes($attributes)
    {
        return [
            'id' => $attributes['id'],
            'name' => $attributes['name'],
            'since' => $attributes['since'],
            'revenue' => $attributes['revenue']
        ];
    }

    public function validationRules()
    {
        return [
            'id' => 'required|integer',
            'name' => 'required|string',
            'since' => 'required|date_format:Y-m-d',
            'revenue' => 'required|numeric'
        ];
    }

    public function changeRevenue($discounts, $orderTotal)
    {
        $value = 0;

        foreach ($discounts as $discount) {
            $value += isset($discount['discount-value']) ? $discount['discount-value'] : 0;
        }

        $totalOrderValue = $orderTotal - number_format($value, 2);

        $this->revenue += $totalOrderValue;
        $this->save();

        return $totalOrderValue;
    }
}
