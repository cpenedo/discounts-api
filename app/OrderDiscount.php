<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    public function validationRules()
    {
        return [
            'order_id' => 'nullable|integer|exists:order,id',
            'discount_id' => 'nullable|integer|exists:discount,id',
        ];
    }
}
