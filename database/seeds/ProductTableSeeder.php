<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->insert([
        	[
	            'id' => 1,
	            'code' => "A101",
	            'description' => 'Screwdriver',
	            'category_id' => 1,
	            'price' => "9.75"
	        ],
	        [
	            'id' => 2,
	            'code' => "A102",
	            'description' => 'Electric screwdriver',
	            'category_id' => 1,
	            'price' => "49.50"
	        ],
	        [
	            'id' => 3,
	            'code' => "B101",
	            'description' => 'Basic on-off switch',
	            'category_id' => 2,
	            'price' => "4.99"
	        ],
	        [
	            'id' => 4,
	            'code' => "B102",
	            'description' => 'Press button',
	            'category_id' => 2,
	            'price' => "4.99"
	        ],
	        [
	            'id' => 5,
	            'code' => "B103",
	            'description' => 'Switch with motion detector',
	            'category_id' => 2,
	            'price' => "12.95"
	        ]
    	]);
    }
}
