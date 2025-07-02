<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\ProductPerWarehouse;
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
        $managerRole = Role::create(['name' => 'Manager']);
        $employeeRole = Role::create(['name' => 'Employee']);
        $volunteerRole = Role::create(['name' => 'Volunteer']);

        // Call CustomerSeeder which includes all families, people, contacts, and users
        $this->call([
            CustomerSeeder::class,
        ]);

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


        $suppliers = [
            1 => Supplier::create([
                'name' => 'Albert Heijn',
                'contact_person' => 'Ruud ter Weijden',
                'supplier_number' => 'L0001',
                'supplier_type' => 'Company',
                'email' => 'albertheijn@example.com',
                'mobiel' => '0612345678'
            ]),
            2 => Supplier::create([
                'name' => 'Albertus Kerk',
                'contact_person' => 'Leo Pastoor',
                'supplier_number' => 'L0002',
                'supplier_type' => 'Institution',
                'email' => 'albertuskerk@example.com',
                'mobiel' => '0623456789'
            ]),
            3 => Supplier::create([
                'name' => 'Gemeente Utrecht',
                'contact_person' => 'Mohammed Yazidi',
                'supplier_number' => 'L0003',
                'supplier_type' => 'Government',
                'email' => 'utrecht@example.com',
                'mobiel' => '0634567890'
            ]),
            4 => Supplier::create([
                'name' => 'Boerderij Meerhoven',
                'contact_person' => 'Bertus van Driel',
                'supplier_number' => 'L0004',
                'supplier_type' => 'Private',
                'email' => 'meerhoven@example.com',
                'mobiel' => '0645678901'
            ]),
            5 => Supplier::create([
                'name' => 'Jan van der Heijden',
                'contact_person' => 'Jan van der Heijden',
                'supplier_number' => 'L0005',
                'supplier_type' => 'Company',
                'email' => 'janvdheijden@example.com',
                'mobiel' => '0656789012'
            ]),
            6 => Supplier::create([
                'name' => 'Vomar',
                'contact_person' => 'Jaco Pastorius',
                'supplier_number' => 'L0006',
                'supplier_type' => 'Company',
                'email' => 'vomar@example.com',
                'mobiel' => '0667890123'
            ]),
            7 => Supplier::create([
                'name' => 'DekaMarkt',
                'contact_person' => 'Sil den Dollaard',
                'supplier_number' => 'L0007',
                'supplier_type' => 'Company',
                'email' => 'dekamarkt@example.com',
                'mobiel' => '0678901234'
            ]),
            8 => Supplier::create([
                'name' => 'Gemeente Vught',
                'contact_person' => 'Jan Blokker',
                'supplier_number' => 'L0008',
                'supplier_type' => 'Government',
                'email' => 'vught@example.com',
                'mobiel' => '0689012345'
            ]),
        ];

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

        // Create warehouses first
        $warehouses = [
            [1, '2025-05-12', null, '5 kg', 20],
            [2, '2025-05-26', null, '2.5 kg', 40],
            [3, '2025-04-02', null, '1 kg', 30],
            [4, '2025-05-16', null, '1.5 kg', 25],
            [5, '2025-05-23', null, '4 stuks', 75],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create([
                'id' => $warehouse[0],
                'date_received' => $warehouse[1],
                'date_delivered' => $warehouse[2],
                'packaging_unit' => $warehouse[3],
                'quantity' => $warehouse[4]
            ]);
        }

        // Products with correct field names
        $products = [

            [1, 1, 'Aardappel', null, '8719587321239', '2025-07-12', 'Kruimige aardappel', 'OpVoorraad'],
            [2, 1, 'Aardappel', null, '8719587321239', '2025-07-26', 'Kruimige aardappel', 'OpVoorraad'],
            [3, 1, 'Ui', null, '8719437321335', '2025-09-02', 'Gele ui', 'NietOpVoorraad'],
            [4, 1, 'Appel', null, '8719486321332', '2025-08-16', 'Granny Smith', 'NietLeverbaar'],
            [5, 1, 'Appel', null, '8719486321333', '2025-09-23', 'Granny Smith', 'NietLeverbaar'],
            [6, 1, 'Banaan', 'Banaan', '8719484321336', '2025-07-12', 'Biologische Banaan', 'OverHoudbaarheidsDatum'],
            [7, 1, 'Banaan', 'Banaan', '8719484321337', '2025-07-19', 'Biologische Banaan', 'OverHoudbaarheidsDatum'],
            [8, 2, 'Kaas', 'Lactose', '8719487421338', '2025-09-19', 'Jonge Kaas', 'OpVoorraad'],
            [9, 2, 'Rosbief', null, '8719487421331', '2025-07-23', 'Rundvlees', 'OpVoorraad'],
            [10, 3, 'Melk', 'Lactose', '8719447321332', '2025-07-23', 'Halfvolle melk', 'OpVoorraad'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create product per warehouse relationships
        $productMagazijn = [
            [1, 1, 1, 'Berlicum'],
            [2, 2, 2, 'Rosmalen'],
            [3, 3, 3, 'Berlicum'],
            [4, 4, 4, 'Berlicum'],
            [5, 5, 5, 'Rosmalen'],
        ];

        foreach ($productMagazijn as $relation) {
            ProductPerWarehouse::create([
                'id' => $relation[0],
                'product_id' => $relation[1],
                'warehouse_id' => $relation[2],
                'location' => $relation[3]
            ]);
        }
        
        $this->call([
            FoodpackagesDataSeeder::class,
        ]);
    }
}
