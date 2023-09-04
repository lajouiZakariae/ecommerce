<?php

use App\Models\Color;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('color_product', function (Blueprint $table) {
            $table->foreignIdFor(Color::class);
            $table->foreignIdFor(Product::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('color_product');
    }
};