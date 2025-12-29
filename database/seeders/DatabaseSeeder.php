<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\EarningSeeder;
use Database\Seeders\WithdrawalSeeder;
use Database\Seeders\ScheduleSeeder;




class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // $this->call([
        //     UserSeeder::class,
        // ]);

        $this->call([
            // UserSeeder::class,
            // ProjectSeeder::class,
            EarningSeeder::class,
            WithdrawalSeeder::class,
            ScheduleSeeder::class,
        ]);


    }
}
