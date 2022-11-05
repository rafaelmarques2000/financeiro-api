<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE transaction ADD column created_at timestamp NOT NULL");
        DB::statement("ALTER TABLE transaction ADD column updated_at timestamp NOT NULL");
        DB::statement("ALTER TABLE transaction ADD column deleted_at timestamp NULL ");
    }
};
