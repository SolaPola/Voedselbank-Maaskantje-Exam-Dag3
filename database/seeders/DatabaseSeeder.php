<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Contact;
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

        // Create test users
        $manager = User::create([
            'login_name' => 'manager',
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
        ]);
        $manager->roles()->attach($managerRole->id);

        $employee = User::create([
            'login_name' => 'employee',
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
        ]);
        $employee->roles()->attach($employeeRole->id);

        $volunteer = User::create([
            'login_name' => 'volunteer',
            'name' => 'Volunteer User',
            'email' => 'volunteer@example.com',
            'password' => Hash::make('password'),
        ]);
        $volunteer->roles()->attach($volunteerRole->id);


        $contacts = [
            1 => Contact::create([
                'street' => 'Prinses Irenestraat', 'house_number' => '12', 'addition' => 'A', 'postal_code' => '5271TH',
                'city' => 'Maaskantje', 'email' => 'j.van.zevenhuizen@gmail.com', 'mobile' => '+31 623456123'
            ]),
            2 => Contact::create([
                'street' => 'Gibraltarstraat', 'house_number' => '234', 'addition' => null, 'postal_code' => '5271TJ',
                'city' => 'Maaskantje', 'email' => 'a.bergkamp@hotmail.com', 'mobile' => '+31 623456123'
            ]),
            3 => Contact::create([
                'street' => 'Der Kinderenstraat', 'house_number' => '456', 'addition' => 'Bis', 'postal_code' => '5271TH',
                'city' => 'Maaskantje', 'email' => 's.van.de.heuvel@gmail.com', 'mobile' => '+31 623456123'
            ]),
            4 => Contact::create([
                'street' => 'Nachtegaalstraat', 'house_number' => '233', 'addition' => 'A', 'postal_code' => '5271TJ',
                'city' => 'Maaskantje', 'email' => 'e.scherder@gmail.com', 'mobile' => '+31 623456123'
            ]),
            5 => Contact::create([
                'street' => 'Bertram Russellstraat', 'house_number' => '45', 'addition' => null, 'postal_code' => '5271TH',
                'city' => 'Maaskantje', 'email' => 'f.de.jong@hotmail.com', 'mobile' => '+31 623456123'
            ]),
            6 => Contact::create([
                'street' => 'Leonardo Da VinciHof', 'house_number' => '34', 'addition' => null, 'postal_code' => '5271ZE',
                'city' => 'Maaskantje', 'email' => 'h.van.der.berg@gmail.com', 'mobile' => '+31 623456123'
            ]),
            7 => Contact::create([
                'street' => 'Siegfried Knutsenlaan', 'house_number' => '234', 'addition' => null, 'postal_code' => '5271ZE',
                'city' => 'Maaskantje', 'email' => 'r.ter.weijden@ah.nl', 'mobile' => '+31 623456123'
            ]),
            8 => Contact::create([
                'street' => 'Theo de Bokstraat', 'house_number' => '256', 'addition' => null, 'postal_code' => '5271ZH',
                'city' => 'Maaskantje', 'email' => 'l.pastoor@gmail.com', 'mobile' => '+31 623456123'
            ]),
            9 => Contact::create([
                'street' => 'Meester van Leerhof', 'house_number' => '2', 'addition' => 'A', 'postal_code' => '5271ZH',
                'city' => 'Maaskantje', 'email' => 'm.yazidi@gemeenteutrecht.nl', 'mobile' => '+31 623456123'
            ]),
            10 => Contact::create([
                'street' => 'Van Wemelenplantsoen', 'house_number' => '300', 'addition' => null, 'postal_code' => '5271TH',
                'city' => 'Maaskantje', 'email' => 'b.van.driel@gmail.com', 'mobile' => '+31 623456123'
            ]),
            11 => Contact::create([
                'street' => 'Terlingenhof', 'house_number' => '20', 'addition' => null, 'postal_code' => '5271TH',
                'city' => 'Maaskantje', 'email' => 'j.pastorius@gmail.com', 'mobile' => '+31 623456356'
            ]),
            12 => Contact::create([
                'street' => 'Veldhoen', 'house_number' => '31', 'addition' => null, 'postal_code' => '5271ZE',
                'city' => 'Maaskantje', 'email' => 's.dollaard@gmail.com', 'mobile' => '+31 623452314'
            ]),
            13 => Contact::create([
                'street' => 'ScheringaDreef', 'house_number' => '37', 'addition' => null, 'postal_code' => '5271ZE',
                'city' => 'Vught', 'email' => 'j.blokker@gemeentevught.nl', 'mobile' => '+31 623452314'
            ]),
        ];

        $suppliers = [
            1 => Supplier::create([
                'name' => 'Albert Heijn',
                'contact_person' => 'Ruud ter Weijden',
                'supplier_number' => 'L0001',
                'supplier_type' => 'Company'
            ]),
            2 => Supplier::create([
                'name' => 'Albertus Kerk',
                'contact_person' => 'Leo Pastoor',
                'supplier_number' => 'L0002',
                'supplier_type' => 'Institution'
            ]),
            3 => Supplier::create([
                'name' => 'Gemeente Utrecht',
                'contact_person' => 'Mohammed Yazidi',
                'supplier_number' => 'L0003',
                'supplier_type' => 'Government'
            ]),
            4 => Supplier::create([
                'name' => 'Boerderij Meerhoven',
                'contact_person' => 'Bertus van Driel',
                'supplier_number' => 'L0004',
                'supplier_type' => 'Private'
            ]),
            5 => Supplier::create([
                'name' => 'Jan van der Heijden',
                'contact_person' => 'Jan van der Heijden',
                'supplier_number' => 'L0005',
                'supplier_type' => 'Donor'
            ]),
            6 => Supplier::create([
                'name' => 'Vomar',
                'contact_person' => 'Jaco Pastorius',
                'supplier_number' => 'L0006',
                'supplier_type' => 'Company'
            ]),
            7 => Supplier::create([
                'name' => 'DekaMarkt',
                'contact_person' => 'Sil den Dollaard',
                'supplier_number' => 'L0007',
                'supplier_type' => 'Company'
            ]),
            8 => Supplier::create([
                'name' => 'Gemeente Vught',
                'contact_person' => 'Jan Blokker',
                'supplier_number' => 'L0008',
                'supplier_type' => 'Government'
            ]),
        ];

        $contactPerSupplier = [
            [1, 7],
            [2, 8],
            [3, 9],
            [4, 10],
            [6, 11],
            [7, 12],
            [8, 13],
        ];
        foreach ($contactPerSupplier as [$supplierId, $contactId]) {
            if (isset($suppliers[$supplierId]) && isset($contacts[$contactId])) {
                $suppliers[$supplierId]->contacts()->syncWithoutDetaching([$contacts[$contactId]->id]);
            }
        }
    }
}
