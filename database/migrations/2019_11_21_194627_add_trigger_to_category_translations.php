<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddTriggerToCategoryTranslations extends Migration
{
    public function up()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $dbPrefix = DB::getTablePrefix();

        //
        DB::unprepared("
            CREATE OR REPLACE FUNCTION {$dbPrefix}category_translations_set_url_path()
            RETURNS trigger AS $$
            DECLARE
                parent_url_path TEXT;
            BEGIN
                -- اگر کتگوری روت نیست
                IF NEW.category_id <> 1 THEN
                    SELECT STRING_AGG(parent_translations.slug, '/' ORDER BY parent._lft)
                    INTO parent_url_path
                    FROM {$dbPrefix}categories AS node
                    JOIN {$dbPrefix}categories AS parent
                      ON node._lft >= parent._lft
                     AND node._rgt <= parent._rgt
                    JOIN {$dbPrefix}category_translations AS parent_translations
                      ON parent.id = parent_translations.category_id
                    WHERE node.id = (
                              SELECT parent_id
                              FROM {$dbPrefix}categories
                              WHERE id = NEW.category_id
                          )
                      AND parent.id <> 1
                      AND parent_translations.locale = NEW.locale
                    GROUP BY node.id;

                    IF parent_url_path IS NULL THEN
                        NEW.url_path := NEW.slug;
                    ELSE
                        NEW.url_path := parent_url_path || '/' || NEW.slug;
                    END IF;
                ELSE
                    -- برای روت (اگر بخواهی می‌توانی خالی بگذاری)
                    NEW.url_path := NEW.slug;
                END IF;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        //
        DB::unprepared("
            DROP TRIGGER IF EXISTS trig_category_translations_insert ON {$dbPrefix}category_translations;
            CREATE TRIGGER trig_category_translations_insert
            BEFORE INSERT ON {$dbPrefix}category_translations
            FOR EACH ROW
            EXECUTE FUNCTION {$dbPrefix}category_translations_set_url_path();
        ");

        //
        DB::unprepared("
            DROP TRIGGER IF EXISTS trig_category_translations_update ON {$dbPrefix}category_translations;
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
            DROP FUNCTION IF EXISTS {$dbPrefix}category_translations_set_url_path();
        ");
    }
}
