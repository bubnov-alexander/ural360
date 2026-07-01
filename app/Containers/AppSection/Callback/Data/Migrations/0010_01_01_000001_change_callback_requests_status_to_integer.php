<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('callback_requests', 'status_tmp')) {
            Schema::table('callback_requests', static function (Blueprint $table): void {
                $table->unsignedTinyInteger('status_tmp')->default(1)->after('status');
            });
        }

        DB::table('callback_requests')
            ->whereIn('status', ['new', '1'])
            ->update(['status_tmp' => 1]);

        DB::table('callback_requests')
            ->whereIn('status', ['in_progress', 'processing', '2'])
            ->update(['status_tmp' => 2]);

        DB::table('callback_requests')
            ->whereIn('status', ['completed', 'processed', 'done', '3'])
            ->update(['status_tmp' => 3]);

        Schema::table('callback_requests', static function (Blueprint $table): void {
            $table->dropColumn('status');
        });

        Schema::table('callback_requests', static function (Blueprint $table): void {
            $table->renameColumn('status_tmp', 'status');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('callback_requests', 'status_tmp')) {
            Schema::table('callback_requests', static function (Blueprint $table): void {
                $table->string('status_tmp')->default('new')->after('status');
            });
        }

        DB::table('callback_requests')
            ->where('status', 1)
            ->update(['status_tmp' => 'new']);

        DB::table('callback_requests')
            ->where('status', 2)
            ->update(['status_tmp' => 'in_progress']);

        DB::table('callback_requests')
            ->where('status', 3)
            ->update(['status_tmp' => 'completed']);

        Schema::table('callback_requests', static function (Blueprint $table): void {
            $table->dropColumn('status');
        });

        Schema::table('callback_requests', static function (Blueprint $table): void {
            $table->renameColumn('status_tmp', 'status');
        });
    }
};
