<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_applicant_list', function (Blueprint $table) {
            $table->unsignedInteger('applicant_list_id');
            $table->unsignedInteger('applicant_id');
            $table->timestamps();

            $table->primary(['applicant_list_id', 'applicant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_list');
    }
}
