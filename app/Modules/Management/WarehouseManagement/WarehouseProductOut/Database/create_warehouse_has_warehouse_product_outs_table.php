<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\WarehouseManagement\WarehouseProductOut\Database\create_warehouse_has_warehouse_product_outs_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouse_has_warehouse_product_outs', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->string('product_name', 100)->nullable();
            $table->bigInteger('quantity')->nullable();

            $table->bigInteger('creator')->unsigned()->nullable();
            $table->string('slug', 50)->nullable();
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
        Schema::dropIfExists('warehouse_has_warehouse_product_outs');
    }
};
