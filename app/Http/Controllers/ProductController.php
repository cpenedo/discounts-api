<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\DiscountServiceApi;
use App\Product;

class ProductController extends Controller
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
        $product = new Product;

        $validator = Validator::make($request->all(), $product->validationRules());
        if ($validator->fails()) {
            return response()->json([
                'error' => 'laravel/validation-exception',
                'message' => 'Invalid product.',
                'fields' => $validator->errors()->all()
            ], 422);
        }

        return DiscountServiceApi::create($product, $product->activeFields());
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
            $products[$index] = new Product;

            $validator = Validator::make($request, $products[$index]->validationRules());
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'laravel/validation-exception',
                    'message' => 'Invalid product.',
                    'fields' => $validator->errors()->all()
                ], 422);
            }

            $attributes[] = $request;
            
        }

        return DiscountServiceApi::createMultiple($products, $attributes);
    }
}

