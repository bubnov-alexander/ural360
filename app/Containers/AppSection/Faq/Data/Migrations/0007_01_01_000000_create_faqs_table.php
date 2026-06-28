<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', static function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('faq_questions', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('faq_id')->constrained('faqs')->cascadeOnDelete();
            $table->string('question');
            $table->text('answer');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_questions');
        Schema::dropIfExists('faqs');
    }
};
