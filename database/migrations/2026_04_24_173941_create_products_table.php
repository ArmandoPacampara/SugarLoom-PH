<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('short_description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->decimal('rating', 3, 1)->default(5.0);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_bakers_choice')->default(false);
            $table->boolean('is_top_pick')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};