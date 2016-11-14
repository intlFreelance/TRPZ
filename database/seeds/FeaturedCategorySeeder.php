<?php

use Illuminate\Database\Seeder;

class FeaturedCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('categories')->insert([
            'name'=>'Featured',
            'image'=>'',
            'created_at'=>$now,
            'updated_at'=>$now
         ]);
    }
}
