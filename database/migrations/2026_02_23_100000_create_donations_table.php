<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('donor_email')->nullable();
            $table->string('donor_phone')->nullable();
            $table->string('donor_type')->default('individual'); // individual, institution, anonymous
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('ILS');
            $table->string('donation_method'); // bank_transfer, cash, card, electronic, other
            $table->date('donation_date');
            $table->string('reference_number')->nullable();
            $table->string('purpose')->nullable(); // general, scholarship, project, tribute
            $table->unsignedBigInteger('purpose_id')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected, refunded
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
