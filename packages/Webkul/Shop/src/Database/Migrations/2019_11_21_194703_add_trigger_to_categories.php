<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddTriggerToCategories extends Migration
{
    public function up()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $dbPrefix = DB::getTablePrefix();

        // تابع تریگر برای categories
        DB::unprepared("
            CREATE OR REPLACE FUNCTION {$dbPrefix}categories_set_url_path()
            RETURNS trigger AS $$
            BEGIN
                NEW.url_path := NEW.slug;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        // تریگر قبل از INSERT
        DB::unprepared("
            DROP TRIGGER IF EXISTS trig_categories_insert ON {$dbPrefix}categories;
            CREATE TRIGGER trig_categories_insert
            BEFORE INSERT ON {$dbPrefix}categories
            FOR EACH ROW
            EXECUTE FUNCTION {$dbPrefix}categories_set_url_path();
        ");

        // تریگر قبل از UPDATE
        DB::unprepared("
            DROP TRIGGER IF EXISTS trig_categories_update ON {$dbPrefix}categories;
            CREATE TRIGGER trig_categories_update
            BEFORE UPDATE ON {$dbPrefix}categories
            FOR EACH ROW
            EXECUTE FUNCTION {$dbPrefix}categories_set_url_path();
        ");
    }

    public function down()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $dbPrefix = DB::getTablePrefix();

        DB::unprepared("
            DROP TRIGGER IF EXISTS trig_categories_insert ON {$dbPrefix}categories;
            DROP TRIGGER IF EXISTS trig_categories_update ON {$dbPrefix}categories;
            DROP FUNCTION IF EXISTS {$dbPrefix}categories_set_url_path();
        ");
    }
}
