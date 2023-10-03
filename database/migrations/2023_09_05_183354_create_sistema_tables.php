<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('color_id')->unsigned();
            $table->bigInteger('size_id')->unsigned();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('cpf', 11)->unique()->nullable();
            $table->string('email', 150)->unique()->nullable();
            $table->string('phone', 14)->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('payment_method_id')->unsigned();
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sale_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('quantity')->default(0);
            $table->decimal('unity_price', 10, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('cnpj', 14)->unique()->nullable();
            $table->string('email', 150)->unique()->nullable();
            $table->string('phone', 14)->nullable();
            $table->string('site', 150)->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('suppliers_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('suppliers_orders_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_order_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('quantity')->default(0);
            $table->decimal('unity_price', 10, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('sizes');
        Schema::dropIfExists('products');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('sales_items');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('suppliers_orders');
        Schema::dropIfExists('suppliers_orders_items');
    }
};
