<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apepo_reports', function (Blueprint $table) {
            $table->id();
            $table->string('manager_username');
            $table->longText('audit')->nullable();
            $table->longText('people')->nullable();
            $table->longText('equipment')->nullable();
            $table->longText('product')->nullable();
            $table->longText('others')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apepo_reports');
    }
};
