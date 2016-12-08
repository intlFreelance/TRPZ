<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CustomersTableSeeder::class);
         $this->call(TransactionsTableSeeder::class);
         $this->call(FeaturedCategorySeeder::class);
         $this->call(OtherCategorySeeder::class);
    }
}
