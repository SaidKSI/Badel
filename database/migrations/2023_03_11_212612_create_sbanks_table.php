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
        Schema::create('Sous_bank', function (Blueprint $table) {
            $table->id();
            $table->string('Sb_name');
            $table->string('profile_picture');
            $table->string('instruction_image')->nullable();
            $table->string('instruction_pdf')->nullable();
            $table->string('prefix');
            $table->boolean('shortTransaction');
            $table->boolean('can_send')->default(true);
            $table->boolean("can_receive")->default(true);
            $table->string("send_account")->default("123456");
            $table->string('transaction_name');
            $table->string("transaction_name_ar");
            $table->unsignedInteger("num_of_characters");
            $table->boolean("only_digit")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Sous_bank');
    }
};
