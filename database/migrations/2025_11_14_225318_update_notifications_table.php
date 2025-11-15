<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {

            $table->string('id', 36)->change();

            if (Schema::hasColumn('notifications', 'user_id')) {
                $table->renameColumn('user_id', 'notifiable_id');
            }

            if (!Schema::hasColumn('notifications', 'notifiable_type')) {
                $table->string('notifiable_type')->default('App\\Models\\User')->after('notifiable_id');
            }

            if (Schema::hasColumn('notifications', 'is_read')) {
                $table->renameColumn('is_read', 'read_at');
            }

            $table->timestamp('read_at')->nullable()->change();

            if (Schema::hasColumn('notifications', 'message')) {
                $table->renameColumn('message', 'data');
            }

            $table->text('data')->change();
        });
    }

    public function down() {}
};
