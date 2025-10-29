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

        // Backfill sensible defaults in a database-agnostic way
        // Username: derive from email + id if empty
        $users = DB::table('users')->select('id', 'email', 'username')->whereNull('username')->get();
        foreach ($users as $u) {
            $email = (string) ($u->email ?? '');
            $base = $email !== '' ? explode('@', $email)[0] : 'user';
            if ($base === '') { $base = 'user'; }
            $candidate = $base.'_'.$u->id;
            DB::table('users')->where('id', $u->id)->update(['username' => $candidate]);
        }

        // Default role to employee if missing
        DB::table('users')->whereNull('role')->update(['role' => 'employee']);

        // Add unique index
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            // SQLite supports IF NOT EXISTS for indexes
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS users_username_unique ON users(username)');
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('username');
            });
        }

        // NOTE: We intentionally do not enforce NOT NULL here to avoid
        // driver-specific ALTER syntax and Doctrine DBAL dependency.
        // Validation and the unique index ensure practical integrity.
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