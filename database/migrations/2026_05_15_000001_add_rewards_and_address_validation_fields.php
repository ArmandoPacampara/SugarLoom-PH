<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('reward_points')->default(0)->after('role');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('points_redeemed')->default(0)->after('discount');
            $table->decimal('points_discount', 10, 2)->default(0)->after('points_redeemed');
            $table->boolean('review_reward_points_awarded')->default(false)->after('reviewed_at');
            $table->unsignedInteger('review_reward_points')->default(0)->after('review_reward_points_awarded');
            $table->string('address_validation_status')->nullable()->after('postal_code');
            $table->string('address_validation_message')->nullable()->after('address_validation_status');
            $table->boolean('address_validation_overridden')->default(false)->after('address_validation_message');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'points_redeemed',
                'points_discount',
                'review_reward_points_awarded',
                'review_reward_points',
                'address_validation_status',
                'address_validation_message',
                'address_validation_overridden',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('reward_points');
        });
    }
};
