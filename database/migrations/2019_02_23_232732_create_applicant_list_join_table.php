<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantListJoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_list_join', function (Blueprint $table) {
            $table->unsignedInteger('list_id');
            $table->unsignedInteger('applicant_id');
            $table->timestamps();

            $table->primary(['applicant_id', 'list_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_list_join');
    }
}
