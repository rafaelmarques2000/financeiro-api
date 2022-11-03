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
            CREATE TABLE transaction(
               id uuid primary key,
               description varchar(200) not null,
               date timestamp not null,
               category_id uuid not null,
               account_id uuid not null,
               amount decimal(10,2) not null,
               installments bool null,
               amount_installments int null,
               current_installment int null,
               foreign key (category_id) references transaction_categories(id),
               foreign key (account_id) references accounts(id)
            );
        ");
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
