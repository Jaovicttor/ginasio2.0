<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSchemas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE SCHEMA IF NOT EXISTS system AUTHORIZATION ". env('DB_USERNAME') .";
            CREATE SCHEMA IF NOT EXISTS gym AUTHORIZATION ". env('DB_USERNAME') .";
            CREATE SCHEMA IF NOT EXISTS sporting_goods AUTHORIZATION ". env('DB_USERNAME') .";
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("
            DROP SCHEMA IF EXISTS system CASCADE;
            DROP SCHEMA IF EXISTS gym CASCADE;
            DROP SCHEMA IF EXISTS sporting_goods CASCADE;
        ");
    }
}
