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
                $table->string('username')->nullable();
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['owner', 'manager', 'employee'])->nullable();
            }
        });

        // Backfill default usernames
        $users = DB::table('users')
            ->select('id', 'email', 'username')
            ->whereNull('username')
            ->get();

        foreach ($users as $u) {
            $email = (string) ($u->email ?? '');
            $base = $email !== '' ? explode('@', $email)[0] : 'user';
            $candidate = $base . '_' . $u->id;
            DB::table('users')
                ->where('id', $u->id)
                ->update(['username' => $candidate]);
        }

        // Default role = employee
        DB::table('users')
            ->whereNull('role')
            ->update(['role' => 'employee']);

        // ✅ Safe unique index creation
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS users_username_unique ON users(username)');
        } elseif ($driver === 'pgsql') {
            // PostgreSQL safe creation
            $exists = DB::select("
                SELECT 1
                FROM pg_indexes
                WHERE schemaname = 'public'
                  AND tablename = 'users'
                  AND indexname = 'users_username_unique'
            ");
            if (empty($exists)) {
                DB::statement('CREATE UNIQUE INDEX users_username_unique ON users(username)');
            }
        } else {
            // MySQL or others
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'username')) return;
                $table->unique('username');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop unique constraint safely
            try {
                $table->dropUnique('users_username_unique');
            } catch (\Throwable $e) {
                // ignore if it doesn't exist
            }

            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
