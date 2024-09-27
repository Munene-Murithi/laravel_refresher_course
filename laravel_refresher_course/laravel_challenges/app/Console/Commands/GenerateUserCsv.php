<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class GenerateUserCsv extends Command
{
    protected $signature = 'users:generate-csv';
    protected $description = 'Generate CSV files containing users.';

    public function handle()
    {
        $users = User::all();
        $totalUsers = $users->count();
        $chunkSize = 10000;
        $folderName = Carbon::now()->format('Y-m-d-') . uniqid() . '-users';
        $folderPath = storage_path("app/$folderName");

        // Create folder if it doesn't exist
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        // Split users into chunks and create CSV files
        foreach ($users->chunk($chunkSize) as $index => $chunk) {
            $filePath = "$folderPath/users_{$index}.csv";
            $file = fopen($filePath, 'w');

            // Add CSV header
            fputcsv($file, ['ID', 'Name', 'Email']); 

            // Write user data
            foreach ($chunk as $user) {
                fputcsv($file, [$user->id, $user->name, $user->email]);
            }

            fclose($file);
        }

        $this->info("CSV files created in $folderPath containing $totalUsers users.");
    }
}
