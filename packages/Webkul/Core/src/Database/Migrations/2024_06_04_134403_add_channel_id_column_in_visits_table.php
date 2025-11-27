<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChannelIdColumnInVisitsTable extends Migration
{
    public function up()
    {
        // فقط اگر جدول وجود دارد، ستون رو اضافه کن
        if (Schema::hasTable('visits')) {
            Schema::table('visits', function (Blueprint $table) {
                if (! Schema::hasColumn('visits', 'channel_id')) {
                    $table->integer('channel_id')->nullable();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('visits') && Schema::hasColumn('visits', 'channel_id')) {
            Schema::table('visits', function (Blueprint $table) {
                $table->dropColumn('channel_id');
            });
        }
    }
}
