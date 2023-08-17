<?php

use App\Models\Category;
use App\Models\Color;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("title");
            $table->string("slug");
            $table->float("cost");
            $table->float("price");
            $table->integer("quantity");
            $table->enum("rating", [1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5]);

            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Category::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};