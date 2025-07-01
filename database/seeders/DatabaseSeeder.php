<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
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

        // Seed categories before products
        $categories = [
            1 => ['name' => 'AGF', 'description' => 'Aardappelen groente en fruit'],
            2 => ['name' => 'KV', 'description' => 'Kaas en vleeswaren'],
            3 => ['name' => 'ZPE', 'description' => 'Zuivel plantaardig en eieren'],
            4 => ['name' => 'BB', 'description' => 'Bakkerij en Banket'],
            5 => ['name' => 'FSKT', 'description' => 'Frisdranken, sappen, koffie en thee'],
            6 => ['name' => 'PRW', 'description' => 'Pasta, rijst en wereldkeuken'],
            7 => ['name' => 'SSKO', 'description' => 'Soepen, sauzen, kruiden en olie'],
            8 => ['name' => 'SKCC', 'description' => 'Snoep, koek, chips en chocolade'],
            9 => ['name' => 'BVH', 'description' => 'Baby, verzorging en hygiëne'],
        ];
        foreach ($categories as $id => $data) {
            Category::firstOrCreate(['id' => $id], $data);
        }

        // Products
        $products = [
            ['category_id' => 1, 'supplier_id' => 1, 'name' => 'Aardappel', 'allergy_type' => null, 'barcode' => '8719587321239',    'expiration_date' => '2024-07-12', 'description' => 'Kruimige aardappel', 'status' => 'OpVoorraad'],
            ['category_id' => 1, 'supplier_id' => 1, 'name' => 'Aardappel', 'allergy_type' => null, 'barcode' => '8719587321240',    'expiration_date' => '2024-07-26', 'description' => 'Kruimige aardappel', 'status' => 'OpVoorraad'],
            ['category_id' => 1, 'supplier_id' => 2, 'name' => 'Ui',        'allergy_type' => null, 'barcode' => '8719437321335',    'expiration_date' => '2024-09-02', 'description' => 'Gele ui', 'status' => 'NietOpVoorraad'],
            ['category_id' => 1, 'supplier_id' => 3, 'name' => 'Appel',     'allergy_type' => null, 'barcode' => '8719486321332',    'expiration_date' => '2024-08-16', 'description' => 'Granny Smith', 'status' => 'NietLeverbaar'],
            ['category_id' => 1, 'supplier_id' => 3, 'name' => 'Appel',     'allergy_type' => null, 'barcode' => '8719486321333',    'expiration_date' => '2024-09-23', 'description' => 'Granny Smith', 'status' => 'NietLeverbaar'],
            ['category_id' => 1, 'supplier_id' => 4, 'name' => 'Banaan',    'allergy_type' => 'Banaan', 'barcode' => '8719484321336', 'expiration_date' => '2024-07-12', 'description' => 'Biologische Banaan', 'status' => 'OverHoudbaarheidsDatum'],
            ['category_id' => 1, 'supplier_id' => 4, 'name' => 'Banaan',    'allergy_type' => 'Banaan', 'barcode' => '8719484321337', 'expiration_date' => '2024-07-19', 'description' => 'Biologische Banaan', 'status' => 'OverHoudbaarheidsDatum'],
            ['category_id' => 2, 'supplier_id' => 5, 'name' => 'Kaas',      'allergy_type' => 'Lactose', 'barcode' => '8719487421338', 'expiration_date' => '2024-09-19', 'description' => 'Jonge Kaas', 'status' => 'OpVoorraad'],
            ['category_id' => 2, 'supplier_id' => 5, 'name' => 'Rosbief',   'allergy_type' => null, 'barcode' => '8719487421331',    'expiration_date' => '2024-07-23', 'description' => 'Rundvlees', 'status' => 'OpVoorraad'],
            ['category_id' => 3, 'supplier_id' => 6, 'name' => 'Melk',      'allergy_type' => 'Lactose', 'barcode' => '8719447321332', 'expiration_date' => '2024-07-23', 'description' => 'Halfvolle melk', 'status' => 'OpVoorraad'],
            ['category_id' => 3, 'supplier_id' => 6, 'name' => 'Margarine', 'allergy_type' => null, 'barcode' => '8719486321336',    'expiration_date' => '2024-08-02', 'description' => 'Plantaardige boter', 'status' => 'OpVoorraad'],
            ['category_id' => 3, 'supplier_id' => 6, 'name' => 'Ei',        'allergy_type' => 'Eier', 'barcode' => '8719487421334',  'expiration_date' => '2024-08-04', 'description' => 'Scharrelei', 'status' => 'OpVoorraad'],
            ['category_id' => 4, 'supplier_id' => 7, 'name' => 'Brood',     'allergy_type' => 'Gluten', 'barcode' => '8719487721337', 'expiration_date' => '2024-07-07', 'description' => 'Volkoren brood', 'status' => 'OpVoorraad'],
            ['category_id' => 4, 'supplier_id' => 7, 'name' => 'Gevulde Koek', 'allergy_type' => 'Amandel', 'barcode' => '8719483321333', 'expiration_date' => '2024-09-04', 'description' => 'Banketbakkers kwaliteit', 'status' => 'OpVoorraad'],
            ['category_id' => 5, 'supplier_id' => 8, 'name' => 'Fristi',    'allergy_type' => 'Lactose', 'barcode' => '8719487121331', 'expiration_date' => '2024-10-28', 'description' => 'Frisdrank', 'status' => 'NietOpVoorraad'],
            ['category_id' => 5, 'supplier_id' => 8, 'name' => 'Appelsap',  'allergy_type' => null, 'barcode' => '8719487521335',    'expiration_date' => '2024-10-19', 'description' => '100% vruchtensap', 'status' => 'OpVoorraad'],
            ['category_id' => 5, 'supplier_id' => 8, 'name' => 'Koffie',    'allergy_type' => 'Caffeïne', 'barcode' => '8719487381338', 'expiration_date' => '2024-10-23', 'description' => 'Arabica koffie', 'status' => 'OverHoudbaarheidsDatum'],
            ['category_id' => 5, 'supplier_id' => 8, 'name' => 'Thee',      'allergy_type' => 'Theïne', 'barcode' => '8719487329339', 'expiration_date' => '2024-09-02', 'description' => 'Ceylon thee', 'status' => 'OpVoorraad'],
            ['category_id' => 6, 'supplier_id' => 1, 'name' => 'Pasta',     'allergy_type' => 'Gluten', 'barcode' => '8719487321334', 'expiration_date' => '2024-12-16', 'description' => 'Macaroni', 'status' => 'NietLeverbaar'],
            ['category_id' => 6, 'supplier_id' => 1, 'name' => 'Rijst',     'allergy_type' => null, 'barcode' => '8719487331332',    'expiration_date' => '2024-12-25', 'description' => 'Basmati Rijst', 'status' => 'OpVoorraad'],
            ['category_id' => 6, 'supplier_id' => 1, 'name' => 'Knorr Nasi Mix', 'allergy_type' => null, 'barcode' => '871948735135', 'expiration_date' => '2024-12-13', 'description' => 'Nasi kruiden', 'status' => 'OpVoorraad'],
            ['category_id' => 7, 'supplier_id' => 2, 'name' => 'Tomatensoep', 'allergy_type' => null, 'barcode' => '8719487371337',  'expiration_date' => '2024-12-23', 'description' => 'Romige tomatensoep', 'status' => 'OpVoorraad'],
            ['category_id' => 7, 'supplier_id' => 2, 'name' => 'Tomatensaus', 'allergy_type' => null, 'barcode' => '8719487341334',  'expiration_date' => '2024-12-21', 'description' => 'Pizza saus', 'status' => 'NietOpVoorraad'],
            ['category_id' => 7, 'supplier_id' => 2, 'name' => 'Peterselie', 'allergy_type' => null, 'barcode' => '8719487321636',   'expiration_date' => '2024-07-31', 'description' => 'Verse kruidenpot', 'status' => 'OpVoorraaad', 'supplier_id' => 2],
            ['category_id' => 8, 'supplier_id' => 3, 'name' => 'Olie',      'allergy_type' => null, 'barcode' => '8719487327337',    'expiration_date' => '2024-12-27', 'description' => 'Olijfolie', 'status' => 'OpVoorraad'],
            ['category_id' => 8, 'supplier_id' => 3, 'name' => 'Mars',      'allergy_type' => null, 'barcode' => '8719487324334',    'expiration_date' => '2024-12-11', 'description' => 'Snoep', 'status' => 'OpVoorraad'],
            ['category_id' => 8, 'supplier_id' => 3, 'name' => 'Biscuit',   'allergy_type' => null, 'barcode' => '8719487311331',    'expiration_date' => '2024-08-07', 'description' => 'San Francisco biscuit', 'status' => 'OpVoorraad'],
            ['category_id' => 8, 'supplier_id' => 3, 'name' => 'Paprika Chips', 'allergy_type' => null, 'barcode' => '87194873218398', 'expiration_date' => '2024-12-22', 'description' => 'Ribbelchips paprika', 'status' => 'OpVoorraad'],
            ['category_id' => 8, 'supplier_id' => 3, 'name' => 'Chocolade reep', 'allergy_type' => 'Cacoa', 'barcode' => '8719487321533', 'expiration_date' => '2024-11-21', 'description' => 'Tony Chocolonely', 'status' => 'OpVoorraad'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Debug tip: Check if products are seeded and linked to suppliers
        // You can temporarily add:
        // dd(Product::all(), Supplier::all());
    }
}


