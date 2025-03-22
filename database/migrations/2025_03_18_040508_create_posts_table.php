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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id', 'idx_posts_user_id')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->string('slug')->unique('idx_posts_slug');
            $table->bigInteger('views', false, true)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
