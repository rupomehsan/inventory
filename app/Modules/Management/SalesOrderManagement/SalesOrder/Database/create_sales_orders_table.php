<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='\App\Modules\Management\SalesOrderManagement\SalesOrder\Database\create_sales_orders_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_title', 100)->nullable();
            $table->string('reference', 50)->nullable();
            $table->integer('customer_id')->nullable();
            $table->datetime('date')->nullable();
            $table->bigInteger('subtotal')->nullable();
            $table->bigInteger('due')->nullable();
            $table->bigInteger('paid')->nullable();
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('total')->nullable();
            $table->enum('order_status', ['pending','due','paid'])->nullable();

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
        Schema::dropIfExists('sales_orders');
    }
};