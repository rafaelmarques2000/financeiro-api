<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up()
    {
        DB::statement('
            ALTER TABLE type_transaction ADD COLUMN slug_name varchar(100) not null unique
        ');
    }
};
