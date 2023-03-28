<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVehicleDocumentsTable extends Migration
{
    public function up()
    {
        Schema::table('vehicle_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('company_vehicle_id')->nullable();
            $table->foreign('company_vehicle_id', 'company_vehicle_fk_8245709')->references('id')->on('company_vehicles');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_8245716')->references('id')->on('users');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_8246774')->references('id')->on('companies');
            $table->unsignedBigInteger('vehicle_document_type_id')->nullable();
            $table->foreign('vehicle_document_type_id', 'vehicle_document_type_fk_8246484')->references('id')->on('vehicle_document_types');
        });
    }
}
