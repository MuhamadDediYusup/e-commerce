<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->foreignIdFor(\App\Models\Category::class)->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->text('photo');
            $table->integer('stock')->default(1);
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->float('price');
            $table->float('discount')->nullable();
            $table->tinyInteger('length')->nullable();
            $table->tinyInteger('width')->nullable();
            $table->tinyInteger('height')->nullable();
            $table->tinyInteger('weight')->nullable();
            $table->boolean('is_featured')->deault(false);
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
        Schema::dropIfExists('products');
    }
}
