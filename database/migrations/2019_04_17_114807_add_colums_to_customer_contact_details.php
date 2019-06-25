<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsToCustomerContactDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_contact_details', function (Blueprint $table) {
            $table->string('city')->after('address_3');
            $table->string('county')->after('city');
            $table->string('post_code')->after('county');
            $table->string('country')->after('post_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_contact_details', function (Blueprint $table) {
            //
        });
    }
}
