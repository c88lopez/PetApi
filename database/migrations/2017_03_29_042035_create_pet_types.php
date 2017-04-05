<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetTypes extends Migration
{
    /**
     * The name of the table.
     * @var string
     */
    protected $tableName = 'pet_types';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
        });

        Schema::table('pets', function (Blueprint $table) {
            $table->integer('pet_type_id')->unsigned();
            $table->foreign('pet_type_id')->references('id')->on('pet_types');
        });

        DB::statement('ALTER TABLE pets MODIFY COLUMN pet_type_id INT(10) UNSIGNED AFTER id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropForeign(['pet_type_id']);
            $table->dropColumn('pet_type_id');
        });

        Schema::drop($this->tableName);
    }
}
