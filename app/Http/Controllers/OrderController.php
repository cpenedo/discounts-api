<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\DiscountServiceApi;
use App\Order;
use App\OrderItem;
use App\Discount;

class OrderController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws PermissionDeniedException
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $order = new Order;

        $orderValidator = Validator::make($request->all(), $order->validationRules());

        if ($orderValidator->fails()) {
            // dd($orderValidator->errors()->all());
            return response()->json([
                'error' => 'laravel/validation-exception',
                'message' => 'Invalid order.',
                'fields' => $orderValidator->errors()->all()
            ], 422);
        }
        $order = $order->create($order->activeFields());

        foreach ($request->items as $index => $item) {
            $orderItems[$index] = new OrderItem;
            $attributes = array_merge($item, ['order-id' => $request->get('id')]);

            $orderItemValidator = Validator::make(
                $attributes,
                $orderItems[$index]->validationRules()
            );

            if ($orderItemValidator->fails()) {
                return response()->json([
                    'error' => 'laravel/validation-exception',
                    'message' => 'Invalid order item.',
                    'fields' => $orderItemValidator->errors()->all()
                ], 422);
            }

            $orderItems[$index]->create($orderItems[$index]->activeFields($attributes));
        }

        $message = [];
        $message['discounts'] = Discount::checkDiscount($order);

        $totalOrderValue = $order->customer->changeRevenue($message['discounts'], $order->total);

        $message['order-total'] = $totalOrderValue;
        $message['message'] = 'Order processed successfully';

        return response()->json($message);
    }
}

