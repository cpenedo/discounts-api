<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
        	[
	            'id' => '1',
	            'name' => 'Tools'
	        ],
	        [
	            'id' => '2',
	            'name' => 'Switches'
	        ]
    	]);
    }
}
