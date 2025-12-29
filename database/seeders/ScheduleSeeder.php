<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\User;


class ScheduleSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        Schedule::insert([
            [
                'user_id' => $user->id,
                'time' => '10:00:00',
                'title' => 'Client Meeting',
                'description' => 'Project discussion with client',
                'type' => 'meeting',
                'schedule_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'time' => '14:00:00',
                'title' => 'Code Review',
                'description' => 'Review pull requests',
                'type' => 'task',
                'schedule_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
