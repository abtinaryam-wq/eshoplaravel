<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddTriggerToCategories extends Migration
{
    private const TRIGGER_NAME_INSERT = 'trig_categories_insert';
    private const TRIGGER_NAME_UPDATE = 'trig_categories_update';

    public function up()
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $dbPrefix = DB::getTablePrefix();

        DB::unprepared(sprintf('DROP TRIGGER IF EXISTS %s', self::TRIGGER_NAME_INSERT));
        DB::unprepared(sprintf('DROP TRIGGER IF EXISTS %s', self::TRIGGER_NAME_UPDATE));

        $insertTrigger = <<<SQL
            CREATE TRIGGER %s
            BEFORE INSERT ON {$dbPrefix}categories
            FOR EACH ROW
            BEGIN
                SET NEW.url_path = NEW.slug;
            END
SQL;

        $updateTrigger = <<<SQL
            CREATE TRIGGER %s
            BEFORE UPDATE ON {$dbPrefix}categories
            FOR EACH ROW
            BEGIN
                SET NEW.url_path = NEW.slug;
            END
SQL;

        DB::unprepared(sprintf($insertTrigger, self::TRIGGER_NAME_INSERT));
        DB::unprepared(sprintf($updateTrigger, self::TRIGGER_NAME_UPDATE));
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
