<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name')->unique();
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
