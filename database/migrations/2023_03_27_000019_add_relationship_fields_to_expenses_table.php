<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToExpensesTable extends Migration
{
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_fk_8245725')->references('id')->on('departments');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_8245726')->references('id')->on('companies');
            $table->unsignedBigInteger('company_vehicle_id')->nullable();
            $table->foreign('company_vehicle_id', 'company_vehicle_fk_8245727')->references('id')->on('company_vehicles');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_8245735')->references('id')->on('users');
        });
    }
}
