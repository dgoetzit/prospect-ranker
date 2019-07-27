<?php

use App\Level;
use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = config('levels.levels');

        foreach($levels as $level) {
          $level = factory(Level::class)->create([
            'name' => $level,
          ]);  
        }
    }
}
