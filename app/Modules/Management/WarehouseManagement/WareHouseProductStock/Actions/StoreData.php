<?php

namespace App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions;

class StoreData
{
    static $model = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;
    static $PurchaseOrderProductModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderProductModel::class;
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;

    public static function execute($request)
    {
        try {

            if (!$request->product_items) {
                return messageResponse('Please add at least one product', [], 500, 'server_error');
            }

            $requestData = $request->validated();

            if ($request->product_items) {
                foreach ($request->product_items as $product_item) {
                    $is_available_for_stock =   self::$PurchaseOrderProductModel::where([
                        'purchase_order_id' => $request->purchase_order_id,
                        'product_id' => $product_item['product_id'],
                    ])->first();

                    if (!$is_available_for_stock || $is_available_for_stock->available_for_stock < $product_item['quantity']) {
                        return messageResponse('Product quantity is not available for : ' . $product_item['product_name'], [], 500, 'server_error');
                    }
                }
            }

            if ($data = self::$model::query()->create($requestData)) {

                if ($request->product_items) {
                    foreach ($request->product_items as $product_item) {
                        $stockProduct =  self::$WareHouseProductStockProductModel::query()->create([
                            'ware_house_product_stock_id' => $data->id,
                            'product_id' => $product_item['product_id'],
                            'product_name' => $product_item['product_name'],
                            'quantity' => $product_item['quantity'],
                        ]);

                        $updateAvailableStock = self::$PurchaseOrderProductModel::where([
                            'purchase_order_id' => $data->purchase_order_id,
                            'product_id' => $product_item['product_id'],
                        ])->first();

                        $updateAvailableStock->available_for_stock = $updateAvailableStock->available_for_stock - $product_item['quantity'];
                        $updateAvailableStock->save();
                        $stockProduct->available_for_stock = $updateAvailableStock->available_for_stock;
                        $stockProduct->save();
                    }
                }
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
