<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix the default rating to be 0.0 instead of 5.0
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('rating', 3, 1)->default(0.0)->change();
        });

        // Any product that still has exactly 5.0 and no actual reviews should be reset to 0.0
        // We'll use 0.0 to signify "No reviews yet"
        Product::where('rating', 5.0)->update(['rating' => 0.0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('rating', 3, 1)->default(5.0)->change();
        });
    }
};
