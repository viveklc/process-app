<?php

namespace Database\Seeders;

use App\Models\Process\Process;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProcessSeeder extends Seeder
{
    private $faker;

    public function __construct(Faker $faker)
    {
            $this->faker = $faker;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<11; $i++){
            Process::create([
                'org_id' => 1,
                'process_name' => $this->faker->jobTitle(),
                'process_description' => $this->faker->paragraph(),
                'valid_from' => '2022-11-25',
                'valid_to' => '2023-11-25',
                'is_recurring' => rand(1,2),
                'total_duration' => rand(1111,9999),
            ]);
        }
    }
}
