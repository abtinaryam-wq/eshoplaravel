<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AlterTriggerOnCategories extends Migration
{
    private const TRIGGER_NAME_INSERT = 'trig_categories_insert';
    private const TRIGGER_NAME_UPDATE = 'trig_categories_update';

    public function up()
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared(sprintf('DROP TRIGGER IF EXISTS %s', self::TRIGGER_NAME_INSERT));
        DB::unprepared(sprintf('DROP TRIGGER IF EXISTS %s', self::TRIGGER_NAME_UPDATE));

        DB::unprepared(sprintf('
            CREATE TRIGGER %s
            BEFORE INSERT ON categories
            FOR EACH ROW
            BEGIN
                SET NEW.url_path = NEW.slug;
            END
        ', self::TRIGGER_NAME_INSERT));

        DB::unprepared(sprintf('
            CREATE TRIGGER %s
            BEFORE UPDATE ON categories
            FOR EACH ROW
            BEGIN
                SET NEW.url_path = NEW.slug;
            END
        ', self::TRIGGER_NAME_UPDATE));
    }

    public function down()
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared(sprintf('DROP TRIGGER IF EXISTS %s', self::TRIGGER_NAME_INSERT));
        DB::unprepared(sprintf('DROP TRIGGER IF EXISTS %s', self::TRIGGER_NAME_UPDATE));
    }
}
