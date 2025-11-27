<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddIndexesToProductRelationTables extends Migration
{
    public function up()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        // Create indexes using raw SQL (PostgreSQL compatible)
        DB::statement("CREATE INDEX IF NOT EXISTS idx_product_price_indices_product_id ON product_price_indices(product_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS idx_product_inventories_product_id ON product_inventories(product_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS idx_product_images_product_id ON product_images(product_id)");
    }

    public function down()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement("DROP INDEX IF EXISTS idx_product_price_indices_product_id");
        DB::statement("DROP INDEX IF EXISTS idx_product_inventories_product_id");
        DB::statement("DROP INDEX IF EXISTS idx_product_images_product_id");
    }
}
