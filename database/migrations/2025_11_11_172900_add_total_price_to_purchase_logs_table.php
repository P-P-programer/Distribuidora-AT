<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('purchase_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_logs', 'total_price')) {
                $table->decimal('total_price', 12, 2)->after('qty');
            }
        });
    }

    public function down(): void
    {
        Schema::table('purchase_logs', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_logs', 'total_price')) {
                $table->dropColumn('total_price');
            }
        });
    }
};