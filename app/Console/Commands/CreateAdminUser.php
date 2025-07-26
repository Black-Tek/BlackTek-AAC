<?php

namespace App\Console\Commands;

use App\Enums\AccountType;
use App\Models\User;
use App\Rules\ValidPassword;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin-user';

    protected $description = 'Create the first admin user';

    public function handle()
    {
        $this->info('🚀 Creating the first admin user...');
        $this->newLine();

        if (User::whereHas('account', function ($query) {
            $query->where('type', AccountType::God);
        })->exists()) {
            $this->error('❌ An admin user already exists!');
            $this->info('💡 If you need to create another admin, update their account type manually in the database.');

            return Command::FAILURE;
        }

        $this->info('📋 Please provide the following information:');
        $this->newLine();

        $name = $this->ask('👤 Name');
        $email = $this->ask('📧 Email address');

        $this->info('🔒 Password requirements: at least 8 characters with uppercase, lowercase, number, and special character');
        $password = $this->secret('🔑 Password');
        $passwordConfirmation = $this->secret('🔑 Confirm password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new ValidPassword, 'confirmed'],
        ]);

        if ($validator->fails()) {
            $this->newLine();
            $this->error('❌ Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error("  • {$error}");
            }

            return Command::FAILURE;
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            $user->account->update([
                'type' => AccountType::God,
            ]);

            $this->newLine();
            $this->info('✅ Success! Admin user created successfully.');
            $this->newLine();
            $this->info("👤 Name: {$user->name}");
            $this->info("📧 Email: {$user->email}");
            $this->info('👑 Account Type: God (Admin)');
            $this->newLine();
            $this->info('🎯 You can now access the admin panel at '.url('/admin'));
            $this->info('🔗 Login URL: '.url('/login'));

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('❌ Error creating admin user: '.$e->getMessage());

            return Command::FAILURE;
        }
    }
}
