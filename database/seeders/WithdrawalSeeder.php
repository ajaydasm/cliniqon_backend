<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Withdrawal;
use App\Models\User;

class WithdrawalSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        Withdrawal::insert([
            [
                'user_id' => $user->id,
                'amount' => 30000,
                'withdrawn_at' => now()->subMonths(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'amount' => 20000,
                'withdrawn_at' => now()->subMonth(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
