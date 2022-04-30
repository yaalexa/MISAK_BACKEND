<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('name');
            $table->string('isbn');
            $table->year('year');
            $table->integer('num_pages');
            $table->integer('priority');
            $table->string('pdf');
            $table->string('img');

            $table->unsignedBigInteger('type_material_id')->nullable();
            $table->foreign('type_material_id')->references('id')->on('type__materials')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('editorial_id')->nullable();
            $table->foreign('editorial_id')->references('id')->on('editorials')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade')->onUpdate('cascade');


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
        Schema::dropIfExists('materials');
    }
}
