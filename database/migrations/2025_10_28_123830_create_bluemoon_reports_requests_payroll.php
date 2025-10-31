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
        Schema::create('manager_reports', function (Blueprint $table) {
            $table->id();
            $table->string('manager_username');
            $table->enum('shift', ['opening','closing']);
            $table->decimal('cash', 12, 2)->default(0);
            $table->decimal('wallet', 12, 2)->default(0);
            $table->decimal('bank', 12, 2)->default(0);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('manager_funds', function (Blueprint $table) {
            $table->id();
            $table->string('manager_username');
            $table->decimal('amount', 12, 2);
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('manager_username');
            $table->longText('note');
            $table->timestamps();
        });

        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('manager_username');
            $table->string('item');
            $table->unsignedInteger('quantity')->default(1);
            $table->enum('priority', ['low','medium','high'])->default('medium');
            $table->text('remarks')->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role'); // employee | manager | owner
            $table->string('email')->nullable();
            $table->enum('employment_type', ['fulltime','parttime'])->default('fulltime');
            $table->timestamps();
        });

        Schema::create('payroll', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->decimal('hourly_rate', 10, 2)->default(0);
            $table->decimal('hours_worked', 10, 2)->default(0);
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('requests');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('manager_funds');
        Schema::dropIfExists('manager_reports');
    }
};
