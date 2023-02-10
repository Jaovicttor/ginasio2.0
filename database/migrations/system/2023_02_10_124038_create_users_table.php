<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = Schema::connection('system');
        if(!$schema->hasTable('users')){
            $schema->create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->uuid('uuid');
                $table->string('username')->unique();
                $table->string('password');
                $table->string('name');
                $table->string('mail')->nullable();
                $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
                $table->boolean('admin')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema = Schema::connection('system');
        $schema->dropIfExists('users');
    }
}
