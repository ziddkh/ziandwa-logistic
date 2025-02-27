<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Destination;
use App\Models\Shipment\TypeOfShipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // $permissions = config('permission-list');
        // foreach ($permissions as $permission) {
        //     Permission::firstOrCreate(['name' => $permission]);
        // }

        // $superAdminUser = User::firstOrCreate(
        //     ['username' => 'superadmin'],
        //     [
        //         'name' => 'Super Admin',
        //         'email' => 'superadmin@gmail.com',
        //         'password' => bcrypt('password'),
        //         'status' => true
        //     ]
        // );

        // $superAdminUser->syncPermissions($permissions);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Destination::firstOrCreate(
        //     [
        //         'name' => 'Ternate Kota',
        //         'cost' => 1800000,
        //     ],
        // );

        // Destination::updateOrCreate(['id' => 1],[
        //     'name' => 'Pelni - Jakarta',
        //     'cost' => 1900000,
        // ]);

        // Destination::updateOrCreate(['id' => 2],[
        //     'name' => 'Pelni - Surabaya',
        //     'cost' => 2000000,
        // ]);

        // Destination::firstOrCreate(
        //     [
        //         'name' => 'Swasta - Jakarta',
        //         'cost' => 1200000,
        //     ],
        // );

        // Destination::firstOrCreate(
        //     [
        //         'name' => 'Swasta - Surabaya',
        //         'cost' => 1200000,
        //     ],
        // );

        // TypeOfShipment::firstOrCreate(
        //     [
        //         'name' => 'Kapal',
        //         'freight' => 1000000,
        //     ],
        // );

        $tantriUser = User::firstOrCreate([
            'username' => 'tantri',
        ], [
            'name' => 'Tantri',
            'email' => 'tantri@gmail.com',
            'password' => bcrypt('Tantri123%%'),
            'status' => true
        ]);

        // $tantriUser->syncRoles('admin');
    }
}
