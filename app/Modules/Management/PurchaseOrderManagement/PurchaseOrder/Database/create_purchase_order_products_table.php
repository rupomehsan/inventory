<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Database\create_purchase_order_products_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_order_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_order_id')->nullable();
            $table->string('product_name')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('price')->nullable()->unsigned();
            $table->bigInteger('currency_id')->nullable();
            $table->bigInteger('quantity')->nullable()->unsigned();
            $table->bigInteger('available_for_stock')->nullable()->unsigned();
            $table->bigInteger('subtotal')->nullable()->unsigned();
            $table->bigInteger('subtotal_in_bdt')->nullable();

            $table->bigInteger('creator')->unsigned()->nullable();
            $table->string('slug', 150)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_products');
    }
};
