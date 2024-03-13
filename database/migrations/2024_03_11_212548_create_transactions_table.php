<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('send_sb_id');
            $table->unsignedBigInteger('receiver_sb_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('send_sb_id')->references('id')->on('sous_bank')->onDelete('cascade');
            $table->foreign('receiver_sb_id')->references('id')->on('sous_bank')->onDelete('cascade');
            $table->string("send_full_name");
            $table->string("send_phone");
            $table->string("receiver_full_name");
            $table->string("receiver_phone");
            $table->decimal('amount', 8, 2);
            $table->decimal('amount_after_tax', 8, 2);
            $table->string('transaction_id');
            $table->string('bedel_id')->nullable();
            $table->time('transaction_time')->nullable();
            $table->time('read_at')->nullable();
            $table->dateTime('terminated_at')->nullable();

            $table->string('supervisor_id')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
