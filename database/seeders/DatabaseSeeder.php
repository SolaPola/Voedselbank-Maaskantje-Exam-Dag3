<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
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

        $categories = [
            ['id' => 1, 'name' => 'AGF', 'description' => 'Aardappelen groente en fruit'],
            ['id' => 2, 'name' => 'KV', 'description' => 'Kaas en vleeswaren'],
            ['id' => 3, 'name' => 'ZPE', 'description' => 'Zuivel plantaardig en eieren'],
            ['id' => 4, 'name' => 'BB', 'description' => 'Bakkerij en Banket'],
            ['id' => 5, 'name' => 'FSKT', 'description' => 'Frisdranken, sappen, koffie en thee'],
            ['id' => 6, 'name' => 'PRW', 'description' => 'Pasta, rijst en wereldkeuken'],
            ['id' => 7, 'name' => 'SSKO', 'description' => 'Soepen, sauzen, kruiden en olie'],
            ['id' => 8, 'name' => 'SKCC', 'description' => 'Snoep, koek, chips en chocolade'],
            ['id' => 9, 'name' => 'BVH', 'description' => 'Baby, verzorging en hygiëne'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $warehouses = [
            [1, '2024-05-12', null, '5 kg', 20],
            [2, '2024-05-26', null, '2.5 kg', 40],
            [3, '2024-04-02', null, '1 kg', 30],
            [4, '2024-05-16', null, '1.5 kg', 25],
            [5, '2024-05-23', null, '4 stuks', 75],
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

        $products = [
            [1, 1, 'Aardappel', null, '8719587321239', '2024-07-12', 'Kruimige aardappel', 'OpVoorraad'],
            [2, 1, 'Aardappel', null, '8719587321239', '2024-07-26', 'Kruimige aardappel', 'OpVoorraad'],
            [3, 1, 'Ui', null, '8719437321335', '2024-09-02', 'Gele ui', 'NietOpVoorraad'],
            [4, 1, 'Appel', null, '8719486321332', '2024-08-16', 'Granny Smith', 'NietLeverbaar'],
            [5, 1, 'Appel', null, '8719486321333', '2024-09-23', 'Granny Smith', 'NietLeverbaar'],
            [6, 1, 'Banaan', 'Banaan', '8719484321336', '2024-07-12', 'Biologische Banaan', 'OverHoudbaarheidsDatum'],
            [7, 1, 'Banaan', 'Banaan', '8719484321337', '2024-07-19', 'Biologische Banaan', 'OverHoudbaarheidsDatum'],
            [8, 2, 'Kaas', 'Lactose', '8719487421338', '2024-09-19', 'Jonge Kaas', 'OpVoorraad'],
            [9, 2, 'Rosbief', null, '8719487421331', '2024-07-23', 'Rundvlees', 'OpVoorraad'],
            [10, 3, 'Melk', 'Lactose', '8719447321332', '2024-07-23', 'Halfvolle melk', 'OpVoorraad'],
        ];

        foreach ($products as $product) {
            Product::create([
                'id' => $product[0],
                'category_id' => $product[1],
                'name' => $product[2],
                'allergy_type' => $product[3],
                'barcode' => $product[4],
                'expiry_date' => $product[5],
                'description' => $product[6],
                'status' => $product[7]
            ]);
        }

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
    }
}
                'warehouse_id' => $relation[2],
                'location' => $relation[3]
            ]);
        }
    }
}
