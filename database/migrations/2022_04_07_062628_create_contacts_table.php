<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->boolean('checked')->nullable();
            $table->text('description')->nullable();
            $table->string('interest')->nullable();
            $table->datetime('date_of_birth')->nullable();
            $table->string('email')->nullable();
            $table->string('account')->nullable();
            $table->string('credit_card_type')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->string('credit_card_name')->nullable();
            $table->string('credit_card_expirationDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
