<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable(); // add nullable first
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['owner', 'manager', 'employee'])->nullable();
            }
        });

        // Backfill sensible defaults if needed
        // Username: derive from email + id if empty
        DB::statement("
            UPDATE users
            SET username = COALESCE(username, split_part(email, '@', 1) || '_' || id)
            WHERE username IS NULL
        ");

        // Default role to employee if missing
        DB::table('users')->whereNull('role')->update(['role' => 'employee']);

        // Add unique index and (optionally) enforce NOT NULL
        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
        });

        // Enforce NOT NULL (Postgres-friendly using raw statement)
        DB::statement('ALTER TABLE users ALTER COLUMN username SET NOT NULL');
        DB::statement('ALTER TABLE users ALTER COLUMN role SET NOT NULL');
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropUnique(['username']);
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};