<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('gateway', 50)->nullable()->after('status');
            $table->string('gateway_status', 100)->nullable()->after('gateway');
            $table->string('gateway_transaction_id')->nullable()->after('gateway_status');
            $table->json('gateway_payload')->nullable()->after('gateway_transaction_id');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn([
                'gateway',
                'gateway_status',
                'gateway_transaction_id',
                'gateway_payload',
            ]);
        });
    }
};
