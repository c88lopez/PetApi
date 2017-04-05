<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class PetTypesTableSeeder extends Seeder
{
    protected $tableName = 'pet_types';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->tableName)->insert(['name' => 'dog']);
        DB::table($this->tableName)->insert(['name' => 'cat']);
        DB::table($this->tableName)->insert(['name' => 'fish']);
    }
}
