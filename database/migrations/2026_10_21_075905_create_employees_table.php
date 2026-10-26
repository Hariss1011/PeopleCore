<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('employee_number', 20)->unique();

            $table->foreignId('department_id')
                ->constrained('departments')
                ->restrictOnDelete();

            $table->foreignId('position_id')
                ->constrained('positions')
                ->restrictOnDelete();

            $table->string('full_name', 150);
            $table->string('email')->nullable()->unique();
            $table->string('phone', 25)->nullable();
            $table->string('gender', 20)->nullable();
            $table->text('address')->nullable();

            $table->date('hire_date');
            $table->string('employment_type', 30);
            $table->date('contract_end_date')->nullable();
            $table->string('employment_status', 20)->default('active');

            $table->timestamps();

            $table->index(['department_id', 'employment_status']);
            $table->index(['position_id', 'employment_status']);
            $table->index('full_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
