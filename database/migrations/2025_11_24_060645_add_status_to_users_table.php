<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_xx_xx_add_role_status_to_users_table.php

public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('user');        // user, admin, assistant_admin
        $table->string('status')->default('pending');   // pending, approved, blocked, etc.
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role', 'status']);
    });
}

};
