<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('unit')->nullable(); // e.g., pcs, kg, L
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('min_threshold')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('inventory_adjustments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->string('manager_username');
            $table->integer('delta'); // can be negative or positive
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('inventory_items')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustments');
        Schema::dropIfExists('inventory_items');
    }
};
