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
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bank_name', 255);
            $table->string('name', 255);
            $table->string('routing_no', 255);
            $table->string('branch', 255);
            $table->string('account_number', 255);
            $table->enum('type', ['Current', 'Savings', 'Deposits', 'NRB', 'DPS']);
            $table->decimal('opening_balance', 12, 2)->default(0.00);
            $table->string('currency', 3)->default('BDT');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unique(['name', 'currency'], 'accounts_name_currency_unique');
            $table->index('created_by', 'accounts_created_by_foreign');
            $table->index('company_id', 'accounts_company_id_foreign');


            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
