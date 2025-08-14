<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('service_job_details', function (Blueprint $table) {
            $table->dropForeign(['services_id']);
            $table->renameColumn('services_id', 'service_id');
        });

        Schema::table('service_job_details', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('service_job_details', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->renameColumn('service_id', 'services_id');
        });

        Schema::table('service_job_details', function (Blueprint $table) {
            $table->foreign('services_id')->references('id')->on('services')->onDelete('cascade');
        });
    }
};
