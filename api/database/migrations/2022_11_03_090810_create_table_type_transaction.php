<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        DB::statement('
            CREATE TABLE type_transaction(
                id uuid primary key,
                description varchar(100) not null,
                created_at timestamp default NOW(),
                updated_at timestamp default NOW(),
                deleted_at timestamp null
            )
       ');
    }

    public function down()
    {
        Schema::dropIfExists('type_transaction');
    }
};
