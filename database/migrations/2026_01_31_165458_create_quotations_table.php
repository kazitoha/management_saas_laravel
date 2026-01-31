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
        Schema::create('quotations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('quotation_number', 255);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('quotation_date', 255);
            $table->string('valid_until', 255);
            $table->string('subtotal', 255);
            $table->string('tax', 255);
            $table->string('discount', 255);
            $table->string('total', 255);
            $table->string('status', 255)->default('Draft');
            $table->longText('note')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unique('quotation_number', 'quotations_quotation_number_unique');
            $table->index('client_id', 'quotations_client_id_foreign');
            $table->index('project_id', 'quotations_project_id_foreign');
            $table->index('company_id', 'quotations_tenant_id_foreign');
            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            $table->foreign('client_id')->references('id')->on('clients')->nullOnDelete();
            $table->foreign('project_id')->references('id')->on('projects')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
