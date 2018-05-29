<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\DiscountServiceApi;
use App\Discount;

class DiscountController extends Controller
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
        $discount = new Discount;

        $validator = Validator::make($request->all(), $discount->validationRules());

        if ($validator->fails()) {
            return response()->json([
                'error' => 'laravel/validation-exception',
                'message' => 'Invalid discount.',
                'fields' => $validator->errors()->all()
            ], 422);
        }
        // $this->validate($request, $discount->validationRules());

        return DiscountServiceApi::create($discount, $discount->activeFields());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function calculate(Request $request)
	{

	}
}