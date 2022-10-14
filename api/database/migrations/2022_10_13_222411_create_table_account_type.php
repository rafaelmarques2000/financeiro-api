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
           CREATE TABLE account_types (
                               id uuid primary key,
                               description varchar(120) not null,
                               slug_name varchar(100) unique,
                               created_at timestamp default NOW(),
                               updated_at timestamp default NOW()
            );
        ");
    }

    public function down()
    {
        Schema::dropIfExists('account_types');
    }
};
