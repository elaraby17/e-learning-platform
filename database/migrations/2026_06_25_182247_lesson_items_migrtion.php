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
        Schema::create('lesson_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lesson_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('type', [
                'video',
                'pdf',
                'file',
                'quiz',
                'assignment',
                'link',
            ]);

            $table->string('title');

            $table->text('description')->nullable();

            $table->string('video_url')->nullable();

            $table->string('file_path')->nullable();

            $table->string('external_link')->nullable();

            $table->integer('order_number')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
