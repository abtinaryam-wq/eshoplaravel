<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AlterTriggerCategoryTranslations extends Migration
{
    public function up()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $dbPrefix = DB::getTablePrefix();

        // فقط تریگرها را دوباره تعریف می‌کنیم تا مطمئن باشیم
        DB::unprepared("
            DROP TRIGGER IF EXISTS trig_category_translations_insert ON {$dbPrefix}category_translations;
            DROP TRIGGER IF EXISTS trig_category_translations_update ON {$dbPrefix}category_translations;

            CREATE TRIGGER trig_category_translations_insert
            BEFORE INSERT ON {$dbPrefix}category_translations
            FOR EACH ROW
            EXECUTE FUNCTION {$dbPrefix}category_translations_set_url_path();

            CREATE TRIGGER trig_category_translations_update
            BEFORE UPDATE ON {$dbPrefix}category_translations
            FOR EACH ROW
            EXECUTE FUNCTION {$dbPrefix}category_translations_set_url_path();
        ");
    }

    public function down()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $dbPrefix = DB::getTablePrefix();

        DB::unprepared("
            DROP TRIGGER IF EXISTS trig_category_translations_insert ON {$dbPrefix}category_translations;
            DROP TRIGGER IF EXISTS trig_category_translations_update ON {$dbPrefix}category_translations;
        ");
    }
}
