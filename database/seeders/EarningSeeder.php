<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Earning;
use App\Models\User;

class EarningSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        for ($i = 1; $i <= 6; $i++) {
            Earning::create([
                'user_id' => $user->id,
                'amount' => rand(20000, 50000),
                'earned_at' => now()->subMonths($i),
            ]);
        }
    }
}
