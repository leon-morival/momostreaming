<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Retrieve all users
        $users = User::all(['id', 'name', 'email']);

        if ($users->isEmpty()) {
            $this->info('No users found.');
            return;
        }

        // Display the users in a table
        $this->table(
            ['ID', 'Name', 'Email'],
            $users->toArray()
        );
    }
}
