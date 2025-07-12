<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportDatabase extends Command
{
    protected $signature = 'db:export';

    protected $description = 'Export user and task tables to JSON';

    public function handle()
    {
        $exportPath = database_path('exports');

        // Ensure the exports directory exists
        if (!File::exists($exportPath)) {
            File::makeDirectory($exportPath, 0755, true);
        }

        // Fetch and export users and tasks
        $users = DB::table('users')->get();
        $tasks = DB::table('tasks')->get();

        File::put("$exportPath/users.json", $users->toJson(JSON_PRETTY_PRINT));
        File::put("$exportPath/tasks.json", $tasks->toJson(JSON_PRETTY_PRINT));

        $this->info('Exported users and tasks to JSON files.');
    }
}