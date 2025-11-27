<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddIndexesToChannelsTables extends Migration
{
    public function up()
    {
        if (DB::getDriverName() === 'pgsql') {
            // فقط اگر ستون‌ها وجود دارند
            if (Schema::hasColumn('channels', 'code')) {
                DB::statement("CREATE INDEX IF NOT EXISTS idx_channels_code ON channels(code)");
            }
            
            if (Schema::hasColumn('channels', 'name')) {
                DB::statement("CREATE INDEX IF NOT EXISTS idx_channels_name ON channels(name)");
            }
        }
    }

    public function down()
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("DROP INDEX IF EXISTS idx_channels_code");
            DB::statement("DROP INDEX IF EXISTS idx_channels_name");
        }
    }
}
