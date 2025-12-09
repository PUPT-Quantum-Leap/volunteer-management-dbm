<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Command
{
    protected $signature = 'user:reset-password {email} {--password=}';
    protected $description = 'Reset a user password';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found!");
            return 1;
        }

        $password = $this->option('password');
        if (!$password) {
            $password = $this->secret('Enter new password');
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info("✅ Password reset successfully for '{$email}'!");
        $this->info("   You can now login with the new password.");
        
        return 0;
    }
}
