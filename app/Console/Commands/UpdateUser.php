<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update 
                            {id : The ID of the user} 
                            {name? : The name of the user} 
                            {email? : The email address of the user} 
                            {password? : The password for the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update an existing user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Retrieve the input arguments
        $userId = $this->argument('id');
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Find the user by ID
        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return;
        }

        // Prepare data for validation
        $data = array_filter([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        // Validate the input data
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'sometimes|required|string|min:8',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        // Update the user with valid data
        if ($name) {
            $user->name = $name;
        }
        if ($email) {
            $user->email = $email;
        }
        if ($password) {
            $user->password = Hash::make($password);
        }

        // Save the updated user
        if ($user->save()) {
            $this->info("User with ID {$userId} updated successfully.");
        } else {
            $this->error("Failed to update user with ID {$userId}.");
        }
    }
}
