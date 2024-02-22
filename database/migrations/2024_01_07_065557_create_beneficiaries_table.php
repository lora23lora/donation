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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('birthdate')->nullable();
            $table->integer('familyMembers')->nullable();
            $table->string('Tel1',100)->nullable();
            $table->string('Tel2',100)->nullable();
            $table->string('status')->nullable();
            $table->tinyInteger('superviser_id')->nullable();
            $table->tinyInteger('city_id')->nullable();
            $table->tinyInteger('user_id')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('active')->default(1);
            $table->string('file',100)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
