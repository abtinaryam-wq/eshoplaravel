<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddLogoPathColumnToLocales extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('locales', 'logo_path')) {
            Schema::table('locales', function (Blueprint $table) {
                $table->string('logo_path')->nullable()->after('code');
            });
        }

        if (DB::getDriverName() === 'pgsql') {
            DB::statement("
                UPDATE locales
                SET logo_path = 'locales/' || code || '.png'
                WHERE logo_path IS NULL;
            ");
        } elseif (DB::getDriverName() === 'mysql') {
            DB::statement("
                UPDATE locales
                SET logo_path = CONCAT('locales/', code, '.png')
                WHERE logo_path IS NULL;
            ");
        }
    }

    public function down()
    {
        Schema::table('locales', function (Blueprint $table) {
            $table->dropColumn('logo_path');
        });
    }
}
