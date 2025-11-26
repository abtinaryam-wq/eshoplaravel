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

        if (! Schema::hasTable($dbPrefix . 'addresses')) {
            Schema::create($dbPrefix . 'addresses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('address_type');
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('company_name')->nullable();
                $table->string('address1')->nullable();
                $table->string('address2')->nullable();
                $table->string('postcode')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('country')->nullable();
                $table->string('phone')->nullable();
                $table->string('vat_id')->nullable();
                $table->boolean('default_address')->default(false);
                $table->jsonb('additional')->nullable();
                $table->timestamps();
            });
        }

        DB::statement("
            INSERT INTO {$dbPrefix}addresses (
                address_type,
                customer_id,
                first_name,
                last_name,
                company_name,
                address1,
                address2,
                postcode,
                city,
                state,
                country,
                phone,
                vat_id,
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
                ca.company_name,
                ca.address1,
                ca.address2,
                ca.postcode::text,
                ca.city,
                ca.state,
                ca.country,
                ca.phone,
                ca.vat_id,
                ca.default_address,
                jsonb_build_object('old_customer_address_id', ca.id),
                NOW(),
                NOW()
            FROM {$dbPrefix}customer_addresses ca
            ON CONFLICT DO NOTHING;
        ");
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
