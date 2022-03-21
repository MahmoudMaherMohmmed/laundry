<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('phone')->unique();
			$table->string('email')->nullable()->unique();
            $table->string('password');
			$table->string('image')->nullable();
            $table->string('lat');
            $table->string('lng');
            $table->integer('status')->default(1)->comment('0=>Not Completed | 1=>Completed');
            $table->string('activation_code')->nullable();
            $table->string('device_token')->nullable();
			$table->string('remember_token')->nullable();
            $table->timestamps(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
