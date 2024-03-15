<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\FlareClient\Http\Exceptions\BadResponse;

class CalculateController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = [];
        $total_consumption = [];

        // Тело запроса должно содержать массив "data"
        if(!$request->data || !is_array($request->data)) return response()->json(['data' => [
            'success' => false,
            'message' => 'Некорректный запрос',
        ]], 400);

        // Рассчет общего кол-ва материалов и расходов
        foreach ($request->data as $item) {
            // Каждый элемент массива "data" должен содержать свойство "name" типа "string" и свойство "count" типа "int"
            if(
                !array_key_exists('name', $item) ||
                !array_key_exists('count', $item) ||
                !is_string($item['name']) ||
                !is_int($item['count']) ||
                $item['count'] < 0
            ) return response()->json(['data' => [
                'success' => false,
                'message' => 'Некорректный запрос',
            ]], 400);

            $product = Product::where('name', $item['name'])->first();

            if(!$product) return response()->json(['data' => [
                'success' => false,
                'message' => 'Не найдено товара с именем "' . $item['name'] . '"',
            ]], 404);

            foreach ($product->consumptions as $consumption) {
                $material = $consumption->material;
                $m_name = $material->name;

                if(array_key_exists($m_name, $total_consumption)) {
                    $total_consumption[$m_name]['consumption'] += $item["count"] * $consumption->count;
                } else {
                    $remains = Pack::where('material_id', $material->id)->pluck('remain')->toArray();
                    $total_remain = array_sum($remains);

                    $total_consumption[$m_name] = [
                        'total' => $total_remain,
                        'consumption' => $item["count"] * $consumption->count,
                    ];
                }
            }
        }

        // Рассчет остатка и нехватки
        foreach ($total_consumption as $name => $item) {
            $product_consumption = $item['total'] - $item['consumption'];

            if($product_consumption > 0) {
                $result = 'остаток';
            } else {
                $result = 'нехватка';
            }

            $data[$result][$name] = abs($product_consumption);
        }

        return response()->json(['data' => [
            'success' => true,
            'result' => $data,
        ]]);
    }
}
