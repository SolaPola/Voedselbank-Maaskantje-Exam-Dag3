<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $managerRole = Role::create(['name' => 'Manager']);
        $employeeRole = Role::create(['name' => 'Employee']);
        $volunteerRole = Role::create(['name' => 'Volunteer']);

        // Call CustomerSeeder which includes all families, people, contacts, and users
        $this->call([
            CustomerSeeder::class,
        ]);

        // Create test users
        $manager = User::create([
            'login_name' => 'manager',
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('1'),
        ]);
        $manager->roles()->attach($managerRole->id);

        $employee = User::create([
            'login_name' => 'employee',
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('1'),
        ]);
        $employee->roles()->attach($employeeRole->id);

        $volunteer = User::create([
            'login_name' => 'volunteer',
            'name' => 'Volunteer User',
            'email' => 'volunteer@example.com',
            'password' => Hash::make('1'),
        ]);
        $volunteer->roles()->attach($volunteerRole->id);
    }
}
