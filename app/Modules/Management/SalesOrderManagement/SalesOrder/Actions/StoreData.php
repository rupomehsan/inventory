<?php

namespace App\Modules\Management\SalesOrderManagement\SalesOrder\Actions;

use Illuminate\Support\Str;

class StoreData
{
    static $model = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\Model::class;
    static $SalesOrderProductModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderProductModel::class;
    static $SalesOrderLogModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderLogModel::class;

    public static function execute($request)
    {
        try {

            if (!$request->product_items) {
                return messageResponse('Please add at least one product', [], 500, 'server_error');
            }

            $requestData = $request->validated();
            $requestData['order_status'] = $request->due == 0  ? 'paid' : 'due';
            if ($data = self::$model::query()->create($requestData)) {
                foreach ($request->product_items as $product) {
                    $createdSalesOrderProduct = self::$SalesOrderProductModel::create([
                        'sales_order_id' => $data->id,
                        'product_id' => $product['product_id'],
                        'product_name' => $product['product_name'],
                        'price' => $product['price'],
                        'quantity' => $product['quantity'],
                        'subtotal' => $product['subtotal'],
                        'creator' => auth()->user()?->id ?? null,
                        'slug' => Str::slug($product['product_name'] ?? 'product') . '-' . uniqid(),
                    ]);
                    // Attach the created product to the sales order
                    $data->sales_order_products()->attach($createdSalesOrderProduct->id, [
                        'creator' => auth()->user()?->id ?? null,
                        'status' => 'active',
                    ]);
                }

                $requestData['sales_order_id'] = $data->id;
                $requestData['sales_order_products'] = $request->product_items;
                self::$SalesOrderLogModel::create($requestData);
            }

            return messageResponse('Item added successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
