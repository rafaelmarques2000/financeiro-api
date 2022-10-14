<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE TABLE users (
                       id uuid primary key ,
                       username varchar(128) not null,
                       password varchar(256) not null,
                       show_name varchar(128) not null,
                       created_at timestamp default NOW(),
                       updated_at timestamp default NOW(),
                       deleted_at timestamp null,
                       active bool not null
            );
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
