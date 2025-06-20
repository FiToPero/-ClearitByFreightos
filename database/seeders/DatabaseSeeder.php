<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = Role::create(['name' => 'user']);
        $agent = Role::create(['name' => 'agent']);

        Permission::create(['name' => 'user']);
        Permission::create(['name' => 'agent']);

        $user->permissions()->attach(Permission::whereIn('name', ['user'])->pluck('id'));
        $agent->permissions()->attach(Permission::whereIn('name', ['agent'])->pluck('id'));


        User::create([
            'role_id' => 1,
            'name' => 'Test_user_role',
            'email' => 'test01@example.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Test_agent_role',
            'email' => 'test02@example.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);



        // \App\Models\User::factory(10)->create();
    }

}
