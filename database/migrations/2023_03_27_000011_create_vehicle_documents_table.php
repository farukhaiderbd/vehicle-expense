<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
