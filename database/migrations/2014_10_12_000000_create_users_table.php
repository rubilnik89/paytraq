<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paytraq_id');
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->string('group_id')->nullable();
            $table->string('contract_number')->nullable();
            $table->string('credit_limit')->nullable();
            $table->string('deposit')->nullable();
            $table->string('discount')->nullable();
            $table->string('pay_term_type')->nullable();
            $table->string('pay_term_days')->nullable();
            $table->string('products_tax_key_id')->nullable();
            $table->string('services_tax_key_id')->nullable();
            $table->string('wrhID')->nullable();
            $table->string('price_group_id')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
