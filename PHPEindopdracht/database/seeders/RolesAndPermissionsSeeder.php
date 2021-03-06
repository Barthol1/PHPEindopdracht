<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $read = Permission::create(['name' => 'lezen']);
        $write = Permission::create(['name' => 'schrijven']);

        $superadmin = Role::create(['name' => 'superadmin']);

        $admin = Role::create(['name' => 'administratief medewerker']);
        $admin->givePermissionTo($read, $write);

        $packagePacker = Role::create(['name' => 'pakket inpakker']);
        $packagePacker->givePermissionTo($read);

        $user = User::factory()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('superadmin'),
        ]);
        $user['api_token'] = $user->createToken('api_token')->plainTextToken;
        $user->assignRole($superadmin);
        $user->save();

        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);
        $user['api_token'] = $user->createToken('api_token')->plainTextToken;
        $user->assignRole($admin);
        $user->save();

        $user = User::factory()->create([
            'name' => 'pakket inpakker',
            'email' => 'pakketinpakker@gmail.com',
            'password' => bcrypt('pakketinpakker'),
        ]);
        $user['api_token'] = $user->createToken('api_token')->plainTextToken;
        $user->assignRole($packagePacker);
        $user->save();

        $user = User::factory()->create([
            'name' => 'Pieter Koekenbakker',
            'email' => 'pieter@koek.com',
            'password' => bcrypt('pieter'),
            'webshops_id' => 1,
        ]);
        $user['api_token'] = $user->createToken('api_token')->plainTextToken;
        $user->save();

        $user = User::factory()->create([
            'name' => 'DHL gebruiker 1',
            'email' => 'dhl@gmail.com',
            'password' => bcrypt('DHL'),
            'transporters_id' => 1,
        ]);
        $user->givePermissionTo($read);
        $user->save();

        $user = User::factory()->create([
            'name' => 'UPS gebruiker 1',
            'email' => 'ups@gmail.com',
            'password' => bcrypt('UPS'),
            'transporters_id' => 2,
        ]);
        $user->givePermissionTo($read);
        $user->save();

    }
}
