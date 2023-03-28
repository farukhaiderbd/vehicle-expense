<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCompanyVehiclesTable extends Migration
{
    public function up()
    {
        Schema::table('company_vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_8245691')->references('id')->on('companies');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_fk_8245692')->references('id')->on('departments');
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->foreign('vehicle_type_id', 'vehicle_type_fk_8245693')->references('id')->on('vehicle_types');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_8245699')->references('id')->on('users');
        });
    }
}
