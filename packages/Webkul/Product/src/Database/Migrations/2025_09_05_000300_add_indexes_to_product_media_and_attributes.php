<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddIndexesToProductMediaAndAttributes extends Migration
{
    public function up()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        // Create indexes using raw SQL (PostgreSQL compatible)
        DB::statement("CREATE INDEX IF NOT EXISTS idx_product_images_product_id ON product_images(product_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS idx_product_videos_product_id ON product_videos(product_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS idx_product_attribute_values_product_id ON product_attribute_values(product_id)");
    }

    public function down()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement("DROP INDEX IF EXISTS idx_product_images_product_id");
        DB::statement("DROP INDEX IF EXISTS idx_product_videos_product_id");
        DB::statement("DROP INDEX IF EXISTS idx_product_attribute_values_product_id");
    }
}
