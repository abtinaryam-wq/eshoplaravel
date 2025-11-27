<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddMinPriceAndMaxPriceColumnInProductFlatTable extends Migration
{
    public function up()
    {
        Schema::table('product_flat', function (Blueprint $table) {
            $table->decimal('min_price', 12, 4)->nullable();
            $table->decimal('max_price', 12, 4)->nullable();
        });

        if (DB::getDriverName() === 'pgsql') {
            //
            DB::statement('ALTER TABLE product_flat ALTER COLUMN special_price TYPE VARCHAR USING special_price::VARCHAR');
            //
            DB::statement('ALTER TABLE product_flat ALTER COLUMN special_price TYPE NUMERIC(12,4) USING special_price::NUMERIC(12,4)');
            DB::statement('ALTER TABLE product_flat ALTER COLUMN special_price DROP NOT NULL');
        } else {
            Schema::table('product_flat', function (Blueprint $table) {
                $table->decimal('special_price', 12, 4)->nullable()->change();
            });
        }
    }

    public function down()
    {
        Schema::table('product_flat', function (Blueprint $table) {
            $table->dropColumn(['min_price', 'max_price']);
        });
    }
}
