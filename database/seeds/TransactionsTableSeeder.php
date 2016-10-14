<?php

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = DB::table('customers')->where('firstName', '=', 'John')->first();
        $now = date('Y-m-d H:i:s');
         DB::table('transactions')->insert([
            'paymentMethod'=>'PayPal',
            'transactionId'=>'1234',
            'customer_id'=>$customer->id,
            'created_at'=>$now,
            'updated_at'=>$now
         ]);
         DB::table('transactions')->insert([
            'paymentMethod'=>'CC',
            'transactionId'=>'567',
            'customer_id'=>$customer->id,
            'created_at'=>$now,
            'updated_at'=>$now
         ]);
    }
}
