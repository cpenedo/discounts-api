<?php

namespace App\Repositories;

use App\Order;
use Illuminate\Support\Facades\DB as DB;

class OrderRepository
{
    public static function getOrderItems($orderId, $categoryId)
    {
        return Order::join('order_item', 'order.id', '=', 'order_item.order_id')
            ->join('product', 'order_item.product_id', '=', 'product.id')
            ->where([
                ['order.id', '=', $orderId],
                ['product.category_id', '=', $categoryId]
            ])
            ->orderBy('product.price', 'asc');
    }

    public static function getOrderItemsSum($orderId, $categoryId)
    {
        $query = self::getOrderItems($orderId, $categoryId)
            ->selectRaw('SUM(order_item.quantity) as quantity_total');

        return $query;
    }
}

