<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        Project::insert([
            [
                'user_id' => $user->id,
                'name' => 'CRM Dashboard',
                'client' => 'ABC Corp',
                'role' => 'Backend Developer',
                'start_date' => now()->subMonths(3),
                'status' => 'ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'name' => 'E-Commerce App',
                'client' => 'XYZ Ltd',
                'role' => 'Full Stack Developer',
                'start_date' => now()->subMonths(6),
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
