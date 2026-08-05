<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('client')->nullable();
            $table->string('category')->nullable();
            $table->string('feature_category')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('video_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_videos');
    }
};
