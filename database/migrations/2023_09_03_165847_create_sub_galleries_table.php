<?php

use App\Models\Gallery;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('sub_galleries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name")->default("sub_gallery");

            $table->foreignIdFor(Gallery::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('sub_galleries');
    }
};