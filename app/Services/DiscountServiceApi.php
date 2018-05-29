<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as DB;

Class DiscountServiceApi
{

    /**
     * @param Model $model
     * @param $attributes
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public static function create($model, $attributes)
    {
        try {
            DB::beginTransaction();

            $model->create($attributes);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => class_basename($model) . ' created.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param Model $model
     * @param $attributes
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public static function createMultiple($models, $attributes)
    {
        try {
            DB::beginTransaction();

            foreach ($attributes as $index => $values) {
                $models[$index]->create($models[$index]->activeFieldsArrayAttributes($values));
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'All ' . class_basename($models[0]) . ' created.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
