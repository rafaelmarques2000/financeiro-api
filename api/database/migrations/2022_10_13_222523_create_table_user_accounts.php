<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        DB::statement('
        CREATE TABLE user_accounts (
                               user_id uuid not null,
                               account_id uuid not null,
                               foreign key (user_id) REFERENCES users (id),
                               foreign key (account_id) REFERENCES accounts (id)
);
       ');
    }

    public function down()
    {
        Schema::dropIfExists('user_accounts');
    }
};
