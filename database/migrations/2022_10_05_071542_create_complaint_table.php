<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint', function (Blueprint $table) {
            $table->id('complaint_id');
            $table->string('complaint_name', 255);
            $table->string('code_request', 255);
            $table->string('mps_user', 255);
            $table->string('main_menu', 255);
            $table->string('categories', 255);
            $table->string('other_categories', 255)->nullable();
            $table->text('description');
            $table->string('request', 255);
            $table->string('reason', 255);
            $table->string('picture', 255);
            $table->string('complaint_source_division', 255);
            $table->string('complaint_classification', 255);
            $table->string('complaint_sub_classification', 255);
            $table->string('complaint_pic', 255);
            $table->string('complaint_treatment', 255);
            $table->string('complaint_user_input', 255);
            $table->string('complaint_status', 255);
            $table->string('complaint_status_code', 255);
            $table->text('treatment')->nullable();
            $table->string('is_active', 15);
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
        Schema::dropIfExists('complaint');
    }
}
