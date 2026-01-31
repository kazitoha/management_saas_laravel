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
        Schema::create('conveyance_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('title', 255);
            $table->string('date', 255);
            $table->string('amount', 255);
            $table->string('status', 255)->default('Pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->longText('note')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->index('reviewed_by', 'conveyance_bills_reviewed_by_foreign');
            $table->index('company_id', 'conveyance_bills_tenant_id_foreign');
            $table->index('user_id', 'conveyance_bills_user_id_foreign');

            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            $table->foreign('reviewed_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenyance_bills');
    }
};
