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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('sku')->unique();
        $table->text('description')->nullable();
        $table->integer('stock_quantity')->default(0);
        $table->decimal('cost_price', 10, 2);
        $table->decimal('selling_price', 10, 2);
        $table->string('image')->nullable();
        $table->integer('color')->nullable();
        $table->date('expiry_date')->nullable();

        // First define the columns
        $table->unsignedBigInteger('brand_id');
        $table->unsignedBigInteger('category_id');
        $table->unsignedBigInteger('subcategory_id')->nullable();
        $table->unsignedBigInteger('quality_id');
        $table->timestamps();
        // Then define the foreign keys
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
