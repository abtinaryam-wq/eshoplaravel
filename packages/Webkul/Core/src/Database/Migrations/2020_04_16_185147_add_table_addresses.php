<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTableAddresses extends Migration
{
    public function up()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $dbPrefix = DB::getTablePrefix();

        // Create addresses table if it doesn't exist
        if (! Schema::hasTable($dbPrefix . 'addresses')) {
            Schema::create($dbPrefix . 'addresses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('address_type');
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('gender')->nullable();
                $table->string('company_name')->nullable();
                $table->string('address1')->nullable();
                $table->string('address2')->nullable();
                $table->string('postcode')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('country')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->boolean('default_address')->default(false);
                $table->jsonb('additional')->nullable();
                $table->timestamps();
            });
        }

        // Migrate data from customer_addresses
        DB::statement("
            INSERT INTO {$dbPrefix}addresses (
                address_type,
                customer_id,
                first_name,
                last_name,
                gender,
                company_name,
                address1,
                address2,
                postcode,
                city,
                state,
                country,
                email,
                phone,
                default_address,
                additional,
                created_at,
                updated_at
            )
            SELECT
                'customer' AS address_type,
                ca.customer_id,
                ca.first_name,
                ca.last_name,
                (SELECT gender FROM {$dbPrefix}customers c WHERE c.id = ca.customer_id),
                ca.company_name,
                ca.address1,
                ca.address2,
                ca.postcode,
                ca.city,
                ca.state,
                ca.country,
                ca.email,
                ca.phone,
                ca.default_address,
                jsonb_build_object('old_customer_address_id', ca.id),
                ca.created_at,
                ca.updated_at
            FROM {$dbPrefix}customer_addresses ca
            WHERE NOT EXISTS (SELECT 1 FROM {$dbPrefix}addresses WHERE additional->>'old_customer_address_id' = ca.id::text);
        ");

        // Migrate data from cart_addresses if table exists
        if (Schema::hasTable($dbPrefix . 'cart_addresses')) {
            DB::statement("
                INSERT INTO {$dbPrefix}addresses (
                    address_type,
                    customer_id,
                    first_name,
                    last_name,
                    gender,
                    company_name,
                    address1,
                    address2,
                    postcode,
                    city,
                    state,
                    country,
                    email,
                    phone,
                    default_address,
                    additional,
                    created_at,
                    updated_at
                )
                SELECT
                    'cart' AS address_type,
                    ca.customer_id,
                    ca.first_name,
                    ca.last_name,
                    NULL AS gender,
                    ca.company_name,
                    ca.address1,
                    ca.address2,
                    ca.postcode,
                    ca.city,
                    ca.state,
                    ca.country,
                    ca.email,
                    ca.phone,
                    false AS default_address,
                    jsonb_build_object('old_cart_address_id', ca.id),
                    ca.created_at,
                    ca.updated_at
                FROM {$dbPrefix}cart_addresses ca
                WHERE NOT EXISTS (SELECT 1 FROM {$dbPrefix}addresses WHERE additional->>'old_cart_address_id' = ca.id::text);
            ");
        }

        // Migrate data from order_addresses if table exists
        if (Schema::hasTable($dbPrefix . 'order_addresses')) {
            DB::statement("
                INSERT INTO {$dbPrefix}addresses (
                    address_type,
                    customer_id,
                    first_name,
                    last_name,
                    gender,
                    company_name,
                    address1,
                    address2,
                    postcode,
                    city,
                    state,
                    country,
                    email,
                    phone,
                    default_address,
                    additional,
                    created_at,
                    updated_at
                )
                SELECT
                    'order' AS address_type,
                    oa.customer_id,
                    oa.first_name,
                    oa.last_name,
                    oa.gender,
                    oa.company_name,
                    oa.address1,
                    oa.address2,
                    oa.postcode,
                    oa.city,
                    oa.state,
                    oa.country,
                    oa.email,
                    oa.phone,
                    false AS default_address,
                    jsonb_build_object('old_order_address_id', oa.id),
                    oa.created_at,
                    oa.updated_at
                FROM {$dbPrefix}order_addresses oa
                WHERE NOT EXISTS (SELECT 1 FROM {$dbPrefix}addresses WHERE additional->>'old_order_address_id' = oa.id::text);
            ");
        }
    }

    public function down()
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $dbPrefix = DB::getTablePrefix();

        if (Schema::hasTable($dbPrefix . 'addresses')) {
            Schema::drop($dbPrefix . 'addresses');
        }
    }
}
