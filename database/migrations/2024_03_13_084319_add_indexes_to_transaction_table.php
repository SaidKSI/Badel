<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction', function (Blueprint $table) {
            // Index for the status column
            // $table->index(['status'], 'transaction_status_index', 'varchar(255)');

            // Indexes for foreign keys
            $table->index('user_id');
            $table->index('send_sb_id');
            $table->index('receiver_sb_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction', function (Blueprint $table) {
            // Drop the indexes if needed
            // $table->dropIndex(['status']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['send_sb_id']);
            $table->dropIndex(['receiver_sb_id']);
        });
    }
}
