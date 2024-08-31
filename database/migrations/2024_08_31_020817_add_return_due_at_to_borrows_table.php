<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturnDueAtToBorrowsTable extends Migration
{
    public function up()
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->timestamp('return_due_at')->nullable()->after('borrowed_at');
        });
    }

    public function down()
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->dropColumn('return_due_at');
        });
    }
}
