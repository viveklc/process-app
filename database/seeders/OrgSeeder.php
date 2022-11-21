<?php

namespace Database\Seeders;

use App\Models\Org;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Org::create([
            'name' => 'Learning concept'
        ]);
    }
}
