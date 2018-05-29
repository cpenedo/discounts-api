<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\DiscountServiceApi;
use App\Category;

class CategoryController extends Controller
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
        $category = new Category;

        $validator = Validator::make($request->all(), $category->validationRules());
        if ($validator->fails()) {
            return response()->json([
                'error' => 'laravel/validation-exception',
                'message' => 'Invalid category.',
                'fields' => $validator->errors()->all()
            ], 422);
        }

        return DiscountServiceApi::create($category, $category->activeFields('single'));
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
        // $category = new Category;
        $attributes = [];

        foreach ($request->toArray() as $index => $request) {
            $categories[$index] = new Category;

            $validator = Validator::make($request, $categories[$index]->validationRules());
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'laravel/validation-exception',
                    'message' => 'Invalid category.',
                    'fields' => $validator->errors()->all()
                ], 422);
            }

            $attributes[] = $request;
            
        }

        return DiscountServiceApi::createMultiple($categories, $attributes);
    }
}

