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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('beneficiary_id');
            $table->integer('amount')->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('approved')->default(0);
            $table->text('note')->nullable();
            // $table->longText('line_items')->nullable();
            $table->date('date')->nullable();
            $table->string('file',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
