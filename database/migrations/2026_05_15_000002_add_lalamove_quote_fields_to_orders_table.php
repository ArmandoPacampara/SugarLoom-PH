<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('lalamove_quotation_id')->nullable()->after('lalamove_tracking_number');
            $table->decimal('delivery_lat', 10, 7)->nullable()->after('delivery_fee');
            $table->decimal('delivery_lng', 10, 7)->nullable()->after('delivery_lat');
            $table->timestamp('lalamove_quote_expires_at')->nullable()->after('delivery_lng');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'lalamove_quotation_id',
                'delivery_lat',
                'delivery_lng',
                'lalamove_quote_expires_at',
            ]);
        });
    }
};
