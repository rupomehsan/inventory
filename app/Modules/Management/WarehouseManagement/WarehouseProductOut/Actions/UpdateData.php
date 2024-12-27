<?php

namespace App\Modules\Management\WarehouseManagement\WarehouseProductOut\Actions;

class UpdateData
{
    static $model = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\Model::class;
    static $WareHouseProductOutProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductOut\Models\WareHouseProductOutProductModel::class;
    static $SalesOrderProductModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderProductModel::class;
    public static function execute($request,$slug)
    {
        try {
            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...', $data, 404, 'error');
            }

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

            if ($request->product_items && count($request->product_items) > 0) {
                $previousrData =  self::$WareHouseProductOutProductModel::where('ware_house_product_out_id', $data->id)->get();
                foreach ($previousrData as $item) {
                    self::$WareHouseProductOutProductModel::where('id', $item->id)->forceDelete();
                }
                foreach ($request->product_items as $product_item) {
                     self::$WareHouseProductOutProductModel::query()->create([
                        'ware_house_product_out_id' => $data->id,
                        'product_id' => $product_item['product_id'],
                        'product_name' => $product_item['product_name'],
                        'quantity' => $product_item['quantity'],
                    ]);
                }
            }
            $requestData = $request->validated();
            $data->update($requestData);
            return messageResponse('Item updated successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}
