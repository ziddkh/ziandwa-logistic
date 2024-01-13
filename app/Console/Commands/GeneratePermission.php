<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class GeneratePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating permissions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permissions = config('permission-list');

        $user = User::where('username', 'superadmin')->first();
        if (empty($user)) {
            $user = User::create([
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('password'),
                'status' => 1,
            ]);
        }

        $this->withSpinner($permissions, function ($permission) use ($user) {
            $permission = Permission::firstOrCreate(['name' => $permission]);
            $user->givePermissionTo($permission);
        }, 'Generating Permissions...');

        $admin = User::where('username', 'admin')->first();
        if (empty($admin)) {
            $user = User::create([
                'name' => 'Iki',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('Logistic2023'),
                'status' => 1,
            ]);
        }
    }
}
