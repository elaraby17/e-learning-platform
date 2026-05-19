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
            ])->default('video');

            $table->text('content')->nullable();

            $table->string('video_url')->nullable();

            $table->integer('video_duration')
                ->nullable();

            $table->boolean('is_free_preview')
                ->default(false);

            $table->integer('order_number')
                ->default(1);

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
