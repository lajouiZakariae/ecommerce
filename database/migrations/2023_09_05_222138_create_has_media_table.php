<?php

use App\Models\HasColorMedia;
use App\Models\Media;
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
        Schema::create('has_media', function (Blueprint $table) {
            $table->foreignIdFor(Media::class);
            $table->foreignId("has_color_media_id")
                ->references("id")
                ->on("has_color_media");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('has_media');
    }
};
