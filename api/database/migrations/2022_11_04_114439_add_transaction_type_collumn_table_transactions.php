<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up()
    {
        DB::statement('
            ALTER TABLE transaction ADD COLUMN transaction_type_id uuid not null;
       ');

        DB::statement('
            ALTER TABLE transaction ADD FOREIGN KEY (transaction_type_id) REFERENCES type_transaction(id);
       ');
    }
};
