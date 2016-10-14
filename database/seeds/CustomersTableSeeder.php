<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('customers')->insert([
            'firstName'=>'John',
            'lastName'=>'Smith',
            'email'=>'example@example.com',
            'password'=>  bcrypt('secret'),
            'address'=>  json_encode([
                'line1'=>'4057W 187th St',
                'line2'=>'',
                'city'=>'Lawndale',
                'state'=>'California',
                'zip'=>'90260',
            ]),
            'created_at'=>$now,
            'updated_at'=>$now
        ]);
    }
}
