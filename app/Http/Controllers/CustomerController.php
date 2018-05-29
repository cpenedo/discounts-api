<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\DiscountServiceApi;
use App\Customer;

class CustomerController extends Controller
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
        $customer = new Customer;

        $validator = Validator::make($request->all(), $customer->validationRules());
        if ($validator->fails()) {
            return response()->json([
                'error' => 'laravel/validation-exception',
                'message' => 'Invalid Customer.',
                'fields' => $validator->errors()->all()
            ], 422);
        }

        return DiscountServiceApi::create($customer, $customer->activeFields());
    }

    /**
     * Store a multiple newly created resources in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws PermissionDeniedException
     * @throws \Exception
     */
    public function storeMultiple(Request $request)
    {
        $attributes = [];

        foreach ($request->toArray() as $index => $request) {
            $customers[$index] = new Customer;

            $validator = Validator::make($request, $customers[$index]->validationRules());
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'laravel/validation-exception',
                    'message' => 'Invalid customer.',
                    'fields' => $validator->errors()->all()
                ], 422);
            }

            $attributes[] = $request;
            
        }

        return DiscountServiceApi::createMultiple($customers, $attributes);
    }
}

