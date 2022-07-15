<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();

            $table->integer('status')->default(1);
            $table->timestamps();

            $table->index('email');
            $table->index('status');
        });

        Schema::create('iten_in_cart', function (Blueprint $table) {
            $table->id();
            $table->integer('cart_id');
            $table->integer('product_id');
            $table->integer('price');
            $table->integer('quantity')->default(1);

            $table->index('cart_id');
            $table->index('product_id');

            $table->timestamps();
        });

        Schema::create('payment_in_cart', function (Blueprint $table) {
            $table->id();
            $table->integer('cart_id');
            $table->integer('payment_id');
            $table->integer('price');

            $table->index('cart_id');
            $table->index('payment_id');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(0);
            $table->integer('inventory');
            $table->integer('price');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('payment_coupon', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('value')->default(0);
            $table->integer('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
        Schema::dropIfExists('iten_in_cart');
        Schema::dropIfExists('payment_in_cart');
        Schema::dropIfExists('products');
        Schema::dropIfExists('payment_coupon');
    }
};
