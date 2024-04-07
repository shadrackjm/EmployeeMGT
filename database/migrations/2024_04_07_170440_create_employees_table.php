<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); //here we added the relationship between the two tables
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->integer('country_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->string('job_title');
            $table->unsignedBigInteger('department_id'); //this is our foreign key + so change the table to departments
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('CASCADE');
            $table->timestamps();

            // since this will be the child table from department we need to delete this and recreate it 
            // this is to give Laravel a correct way to create relationship we created,
            // for now if we migrate this table it will give us error.. let me show you!
            // so let me copy it's contents and create it again..
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
