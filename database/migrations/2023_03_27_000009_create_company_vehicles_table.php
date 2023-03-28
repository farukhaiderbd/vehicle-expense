<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('company_vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('registration_number')->unique();
            $table->string('plate_number');
            $table->string('license_number');
            $table->date('license_issues_date')->nullable();
            $table->date('license_expire_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
