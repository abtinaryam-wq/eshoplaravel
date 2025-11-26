<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AlterStoredFunctionUrlPathCategory extends Migration
{
    public function up()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $dbPrefix = DB::getTablePrefix();

        DB::unprepared("
            DROP FUNCTION IF EXISTS get_url_path_of_category(integer, varchar);

            CREATE OR REPLACE FUNCTION get_url_path_of_category(
                categoryId INT,
                localeCode VARCHAR
            )
            RETURNS VARCHAR AS $$
            DECLARE
                urlPath TEXT;
            BEGIN
                IF categoryId <> 1 THEN
                    SELECT STRING_AGG(parent_translations.slug, '/' ORDER BY parent._lft)
                    INTO urlPath
                    FROM {$dbPrefix}categories AS node
                    JOIN {$dbPrefix}categories AS parent
                        ON node._lft >= parent._lft
                        AND node._rgt <= parent._rgt
                    JOIN {$dbPrefix}category_translations AS parent_translations
                        ON parent.id = parent_translations.category_id
                    WHERE node.id = categoryId
                      AND parent.id <> 1
                      AND parent_translations.locale = localeCode
                    GROUP BY node.id;

                    IF urlPath IS NULL THEN
                        SELECT slug
                        INTO urlPath
                        FROM {$dbPrefix}category_translations
                        WHERE category_id = categoryId
                        LIMIT 1;
                    END IF;
                ELSE
                    urlPath := '';
                END IF;

                RETURN urlPath;
            END;
            $$ LANGUAGE plpgsql STABLE;
        ");
    }

    public function down()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::unprepared('DROP FUNCTION IF EXISTS get_url_path_of_category(integer, varchar);');
    }
}
