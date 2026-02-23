<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // expense, transfer, grant_payment, project_funding
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('ILS');
            $table->date('transaction_date');
            $table->string('beneficiary_name');
            $table->string('beneficiary_type')->default('other'); // student, institution, project, other
            $table->text('purpose');
            $table->string('reference_type')->nullable(); // ScholarshipApplication, etc.
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('payment_method'); // bank_transfer, cheque, cash
            $table->string('bank_reference')->nullable();
            $table->string('status')->default('draft'); // draft, pending_review, approved, rejected, completed
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
