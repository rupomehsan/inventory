<?php

namespace App\Modules\Management\WarehouseManagement\WarehouseProductOut\Actions;

class StoreData
{
    static $model = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\Model::class;
    static $SalesOrderProductModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderProductModel::class;
    static $WareHouseProductOutProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductOut\Models\WareHouseProductOutProductModel::class;
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;

    public static function execute($request)
    {
        try {

            // if (!$request->product_items) {
            //     return messageResponse('Please add at least one product', [], 500, 'server_error');
            // }

            $requestData = $request->validated();

            dd($requestData);

            if ($request->product_items) {
                foreach ($request->product_items as $product_item) {
                    $is_available_for_stock =   self::$SalesOrderProductModel::where([
                        'sales_order_id' => $request->sales_order_id,
                        'product_id' => $product_item['product_id'],
                    ])->first();

                    if (!$is_available_for_stock || $is_available_for_stock->quantity < $product_item['quantity']) {
                        return messageResponse('Product quantity is not available for : ' . $product_item['product_name'], [], 500, 'server_error');
                    }
                }
            }


            if ($data = self::$model::query()->create($requestData)) {
                if ($request->product_items) {
                    foreach ($request->product_items as $product_item) {

                        self::$WareHouseProductOutProductModel::query()->create([
                            'ware_house_product_out_id' => $data->id,
                            'product_id' => $product_item['product_id'],
                            'product_name' => $product_item['product_name'],
                            'quantity' => $product_item['quantity'],
                        ]);

                        $remainingQuantity = $product_item['quantity'];

                        $StockProductUpdateQuantity =   self::$WareHouseProductStockProductModel::query()
                            ->where('product_id', $product_item['product_id'])
                            ->orderBy('quantity', 'asc')
                            ->get();

                        foreach ($StockProductUpdateQuantity as $warehouseStock) {
                            if ($remainingQuantity <= 0) {
                                break;
                            }
                            $deductAmount = min($warehouseStock->quantity, $remainingQuantity);
                            $warehouseStock->update([
                                'quantity' => $warehouseStock->quantity - $deductAmount,
                            ]);
                            $remainingQuantity -= $deductAmount;
                        }

                        if ($remainingQuantity > 0) {
                            return messageResponse(
                                'Insufficient stock to remove the requested quantity for product ID ' . $product_item['product_id'],
                                [],
                                400
                            );
                        }
                    }
                }
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
