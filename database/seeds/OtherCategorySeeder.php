<?php

use Illuminate\Database\Seeder;

class OtherCategorySeeder extends Seeder
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
            'name'=>'Other',
            'image'=>'',
            'created_at'=>$now,
            'updated_at'=>$now
         ]);
    }
}
