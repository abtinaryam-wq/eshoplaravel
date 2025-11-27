<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddIndexesToChannelsTables extends Migration
{
    public function up()
    {
        if (DB::getDriverName() === 'pgsql') {
            // PostgreSQL way: use raw SQL
            DB::statement("CREATE INDEX IF NOT EXISTS idx_channels_code ON channels(code)");
            DB::statement("CREATE INDEX IF NOT EXISTS idx_channels_name ON channels(name)");
        } else {
            // MySQL way
            Schema::table('channels', function (Blueprint $table) {
                if (! $this->hasIndex('channels', 'idx_channels_code')) {
                    $table->index('code', 'idx_channels_code');
                }
                if (! $this->hasIndex('channels', 'idx_channels_name')) {
                    $table->index('name', 'idx_channels_name');
                }
            });
        }
    }

    public function down()
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("DROP INDEX IF EXISTS idx_channels_code");
            DB::statement("DROP INDEX IF EXISTS idx_channels_name");
        } else {
            Schema::table('channels', function (Blueprint $table) {
                $table->dropIndex('idx_channels_code');
                $table->dropIndex('idx_channels_name');
            });
        }
    }

    protected function hasIndex($table, $indexName)
    {
        return DB::select(
            "SELECT 1 FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = ? AND index_name = ?",
            [$table, $indexName]
        );
    }
}
