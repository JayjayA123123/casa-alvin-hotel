<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class BootstrapAdmin extends Command
{
    protected $signature = 'admin:bootstrap
        {email : Email address ng gagawing admin}
        {name=Admin User : Buong pangalan}
        {password=changeme123 : Password na gagamitin}';

    protected $description = 'Gumawa o i-promote ang isang user to admin role. Safe itong i-rerun (idempotent).';

    public function handle(): int
    {
        $email = strtolower($this->argument('email'));
        $name = $this->argument('name');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->role = 'admin';
            if ($this->argument('password') !== 'changeme123') {
                $user->password = Hash::make($password);
            }
            $user->save();
            $this->info("Na-promote to admin: {$email}");
            return self::SUCCESS;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info("Nagawa na bagong admin account: {$email}");
        return self::SUCCESS;
    }
}
