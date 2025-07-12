<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'user')->get();

        Task::create([
            'title' => 'Complete Project Documentation',
            'description' => 'Write comprehensive documentation for the new project including setup instructions and API endpoints.',
            'user_id' => $users->first()->id,
            'status' => 'pending',
            'deadline' => Carbon::now()->addDays(7)
        ]);

        Task::create([
            'title' => 'Fix Login Bug',
            'description' => 'Resolve the authentication issue where users cannot login with special characters in password.',
            'user_id' => $users->first()->id,
            'status' => 'in_progress',
            'deadline' => Carbon::now()->addDays(3)
        ]);

        Task::create([
            'title' => 'Update Database Schema',
            'description' => 'Add new columns to users table and create migration for the changes.',
            'user_id' => $users->last()->id,
            'status' => 'completed',
            'deadline' => Carbon::now()->addDays(5)
        ]);

        Task::create([
            'title' => 'Design User Interface',
            'description' => 'Create wireframes and mockups for the new dashboard interface.',
            'user_id' => $users->last()->id,
            'status' => 'pending',
            'deadline' => Carbon::now()->addDays(10)
        ]);
    }
}