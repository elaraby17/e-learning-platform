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
        Schema::create('lessons', function (Blueprint $table) {
    $table->id();

    $table->foreignId('section_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->string('title');

    $table->enum('type', [
        'video',
        'article',
        'quiz',
    ]);

    $table->longText('content')->nullable();

    $table->string('video_url')->nullable();

    $table->integer('video_duration')->nullable();

    $table->string('video_thumbnail')->nullable();

    $table->boolean('is_free_preview')->default(false);

    $table->unsignedInteger('order_number')->default(0);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
