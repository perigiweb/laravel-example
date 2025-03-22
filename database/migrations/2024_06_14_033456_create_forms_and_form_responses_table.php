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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('title');
            $table->mediumText('description');
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        Schema::create('form_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->nullable()->constrained(
                table: 'forms',
                indexName: 'idx_form_inputs_form_id'
            )->cascadeOnDelete()->noActionOnUpdate();
            $table->string('label');
            $table->string('input_type');
            $table->boolean('required')->default(false);
            $table->json('params');
            $table->timestamps();
        });

        Schema::create('form_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->nullable()->constrained(
                table: 'forms',
                indexName: 'idx_responses_form_id'
            )->cascadeOnDelete()->noActionOnUpdate();
            $table->foreignId('user_id')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('form_response_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->nullable()->constrained(
                table: 'form_responses',
                indexName: 'idx_answers_response_id'
            )->cascadeOnDelete()->noActionOnUpdate();
            $table->foreignId('input_id')->nullable()->constrained(
                table: 'forms',
                indexName: 'idx_answers_input_id'
            )->cascadeOnDelete()->noActionOnUpdate();
            $table->longText('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_response_answers');
        Schema::dropIfExists('form_responses');
        Schema::dropIfExists('form_inputs');
        Schema::dropIfExists('forms');
    }
};
