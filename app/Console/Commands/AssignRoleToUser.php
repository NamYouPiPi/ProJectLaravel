<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class AssignRoleToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-role {email} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a role to a user by email address';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $roleName = $this->argument('role');

        // Find the user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            return Command::FAILURE;
        }

        // Find the role
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            $this->error("Role '{$roleName}' not found!");
            $this->info('Available roles: customer, employee, admin, super_admin');
            return Command::FAILURE;
        }

        // Assign the role
        $user->role_id = $role->id;
        $user->save();

        $this->info("Successfully assigned role '{$roleName}' to user {$email}");

        return Command::SUCCESS;
    }
}
