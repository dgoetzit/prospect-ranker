<?php

use App\Year;
use Illuminate\Database\Seeder;

class YearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $years = config('years.years');

        foreach($years as $year) {
          $years = factory(Year::class)->create([
            'year' => $year,
          ]);  
        }
    }
}
