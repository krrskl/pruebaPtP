<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as f;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $faker = f::create();
        foreach (range(1,20) as $item) {
            DB::table('persons')->insert([
                'firstName' => $faker->name,
                'documentType' => "CC",
                'document' => 123456,
	            'lastName' => $faker->lastName,
                'company' => $faker->company,
                'emailAddress' => $faker->email,
                'address' => $faker->address,
                'city' => $faker->city,
                'province' => $faker->state,
                'country' => $faker->countryCode,
                'phone' =>$faker->tollFreePhoneNumber,
                'mobile'=>$faker->e164PhoneNumber
	        ]);
        }
    }
}
