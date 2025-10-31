<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'position')) {
                $table->string('position')->nullable()->after('email');
            }
            if (!Schema::hasColumn('employees', 'birthday')) {
                $table->date('birthday')->nullable()->after('position');
            }
            if (!Schema::hasColumn('employees', 'contact')) {
                $table->string('contact')->nullable()->after('birthday');
            }
            if (!Schema::hasColumn('employees', 'join_date')) {
                $table->date('join_date')->nullable()->after('contact');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'join_date')) $table->dropColumn('join_date');
            if (Schema::hasColumn('employees', 'contact')) $table->dropColumn('contact');
            if (Schema::hasColumn('employees', 'birthday')) $table->dropColumn('birthday');
            if (Schema::hasColumn('employees', 'position')) $table->dropColumn('position');
        });
    }
};