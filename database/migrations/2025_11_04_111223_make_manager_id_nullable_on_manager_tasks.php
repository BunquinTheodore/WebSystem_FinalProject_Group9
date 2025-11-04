<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('manager_tasks')) {
            // Postgres: drop NOT NULL
            DB::statement('ALTER TABLE manager_tasks ALTER COLUMN manager_id DROP NOT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('manager_tasks')) {
            // Postgres: set back to NOT NULL (will fail if nulls exist)
            DB::statement('ALTER TABLE manager_tasks ALTER COLUMN manager_id SET NOT NULL');
        }
    }
};