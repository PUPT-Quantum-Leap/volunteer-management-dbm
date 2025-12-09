<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class TestLogin extends Command
{
    protected $signature = 'test:login {email} {password}';
    protected $description = 'Test if login credentials work';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ User with email '{$email}' NOT FOUND in database!");
            $this->info("\n📋 All users in database:");
            User::all()->each(function($u) {
                $this->line("  - {$u->email} (role: {$u->role})");
            });
            return 1;
        }

        $this->info("✅ User found: {$user->email}");
        $this->info("   Role: {$user->role}");
        $this->info("   Name: {$user->name}");

        if (Hash::check($password, $user->password)) {
            $this->info("✅ Password is CORRECT!");
            $this->info("\n🎉 Login should work!");
            return 0;
        } else {
            $this->error("❌ Password is INCORRECT!");
            $this->warn("\n💡 To reset password, run:");
            $this->line("   php artisan user:reset-password {$email}");
            return 1;
        }
    }
}
