<?php

use App\Models\Media;
use App\Models\Product;
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
        Schema::create("media_product", function (Blueprint $table) {
            $table->integer("order")->default(0);
            $table->foreignIdFor(Product::class);
            $table->foreignIdFor(Media::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("media_product");
    }
};
