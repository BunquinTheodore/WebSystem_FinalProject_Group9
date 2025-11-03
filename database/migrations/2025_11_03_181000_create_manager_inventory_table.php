<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manager_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('manager_username');
            $table->string('product_name');
            $table->string('unit')->default('kg');
            $table->integer('sealed')->default(0);
            $table->integer('loose')->default(0);
            $table->integer('delivered')->default(0);
            $table->boolean('submitted')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manager_inventory');
    }
};
