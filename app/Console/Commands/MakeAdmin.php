<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

/**
 * Create an admin account, or give admin rights to an existing account.
 *
 *   php artisan make:admin
 */
class MakeAdmin extends Command
{
    protected $signature = 'make:admin {--email= : Email of the admin account}';

    protected $description = 'Create an IndoScholar admin account (or make an existing account admin)';

    public function handle(): int
    {
        $email = $this->option('email') ?: text(
            label: 'Admin email',
            required: true,
            validate: fn ($value) => filter_var($value, FILTER_VALIDATE_EMAIL) ? null : 'Enter a valid email address.'
        );
        $email = strtolower(trim($email));

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->forceFill(['role' => 'admin'])->save();
            $this->info("{$email} is now an admin. Their password was not changed.");

            return self::SUCCESS;
        }

        $name = text(label: 'Admin name', required: true);
        $plain = password(label: 'Password (at least 10 characters)', required: true);
        $confirm = password(label: 'Repeat the password', required: true);

        $validator = Validator::make(
            ['password' => $plain, 'password_confirmation' => $confirm],
            ['password' => ['required', 'confirmed', Password::min(10)]]
        );

        if ($validator->fails()) {
            $this->error($validator->errors()->first('password'));

            return self::FAILURE;
        }

        User::forceCreate([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($plain),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->info("Admin account created for {$email}.");

        return self::SUCCESS;
    }
}
