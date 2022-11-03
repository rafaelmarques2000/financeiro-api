<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE TABLE transaction_categories(
                id uuid primary key,
                description varchar(100) not null,
                type_transaction_id uuid not null,
                created_at timestamp default NOW(),
                updated_at timestamp default NOW(),
                deleted_at timestamp null,
                foreign key (type_transaction_id) references type_transaction(id)
            );
       ");
    }

    public function down()
    {
        Schema::dropIfExists('transaction_categories');
    }
};
