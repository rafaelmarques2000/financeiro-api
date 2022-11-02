<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        DB::statement('
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
        ');
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
