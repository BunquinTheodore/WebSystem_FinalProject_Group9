<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('manager_funds', function (Blueprint $table) {
            if (!Schema::hasColumn('manager_funds', 'fund_image_path')) {
                $table->string('fund_image_path')->nullable()->after('amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('manager_funds', function (Blueprint $table) {
            if (Schema::hasColumn('manager_funds', 'fund_image_path')) {
                $table->dropColumn('fund_image_path');
            }
        });
    }
};
