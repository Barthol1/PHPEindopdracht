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
            'adres' => str::random(10),
            'plaats'=> str::random(10),
            'postcode' => str::random(4)
        ]);
        $user->assignRole($superadmin);

        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'adres' => str::random(10),
            'plaats'=> str::random(10),
            'postcode' => str::random(4)
        ]);
        $user->assignRole($admin);

        $user = User::factory()->create([
            'name' => 'pakket inpakker',
            'email' => 'pakketinpakker@gmail.com',
            'password' => bcrypt('pakketinpakker'),
            'adres' => str::random(10),
            'plaats'=> str::random(10),
            'postcode' => str::random(4)
        ]);
        $user->assignRole($packagePacker);
    }
}
