<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleDocumentTypesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_document_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
