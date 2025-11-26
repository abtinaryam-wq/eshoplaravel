<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AlterTriggerCategoryTranslations extends Migration
{
    private const TRIGGER_NAME_INSERT = 'trig_category_translations_insert';
    private const TRIGGER_NAME_UPDATE = 'trig_category_translations_update';

    public function up()
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared(sprintf('DROP TRIGGER IF EXISTS %s', self::TRIGGER_NAME_INSERT));
        DB::unprepared(sprintf('DROP TRIGGER IF EXISTS %s', self::TRIGGER_NAME_UPDATE));

        DB::unprepared(sprintf('
            CREATE TRIGGER %s
            BEFORE INSERT ON category_translations
            FOR EACH ROW
            BEGIN
                SET NEW.url_path = (SELECT slug FROM categories WHERE id = NEW.category_id);
            END
        ', self::TRIGGER_NAME_INSERT));

        DB::unprepared(sprintf('
            CREATE TRIGGER %s
            BEFORE UPDATE ON category_translations
            FOR EACH ROW
            BEGIN
                SET NEW.url_path = (SELECT slug FROM categories WHERE id = NEW.category_id);
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
