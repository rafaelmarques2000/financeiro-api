<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up()
    {
        DB::statement('
            ALTER TABLE account_types ADD COLUMN color varchar(50)
        ');
    }
};
