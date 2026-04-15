<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'shop_id')) {  // <-- add this check
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('shop_id')->nullable()->constrained()->cascadeOnDelete();
                $table->enum('role', ['superadmin','shop_admin','staff'])->default('shop_admin');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'shop_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['shop_id']); // drop FK first
                $table->dropColumn('shop_id');
                $table->dropColumn('role');
            });
        }
    }
};