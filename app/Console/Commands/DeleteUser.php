<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete {id : The ID of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a user by their ID';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Retrieve the user ID argument
        $userId = $this->argument('id');

        // Find the user by ID
        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return;
        }

        // Delete the user
        if ($user->delete()) {
            $this->info("User with ID {$userId} deleted successfully.");
        } else {
            $this->error("Failed to delete user with ID {$userId}.");
        }
    }
}
