<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        DB::statement('
           CREATE TABLE accounts(
                         id uuid primary key ,
                         description varchar(256) not null ,
                         account_type_id uuid not null ,
                         created_at timestamp default now(),
                         updated_at timestamp default now(),
                         deleted_at timestamp null,
                         foreign key(account_type_id)  REFERENCES account_types(id)
);
        ');
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
