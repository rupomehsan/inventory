<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Database\create_purchase_orders_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->string('reference', 100)->nullable();
            $table->integer('suppliyer_id')->nullable();
            $table->datetime('date')->nullable();
            $table->integer('currency_id')->nullable();
            $table->bigInteger('currency_exchange_rate')->nullable();
            $table->date('expected_time_of_delivery')->nullable();
            $table->bigInteger('subtotal')->nullable();
            $table->bigInteger('discount')->nullable();
            $table->string('total', 100)->nullable();
            $table->bigInteger('total_in_bd')->nullable();

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
        Schema::dropIfExists('purchase_orders');
    }
};