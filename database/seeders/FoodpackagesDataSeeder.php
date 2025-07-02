<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FoodpackagesDataSeeder extends Seeder
{
    /**
     * Seed the database with dummy data based on the provided tables.
     */
    public function run(): void
    {


        // Seed Eetwens (Diet Preference) table
        $dietPreferences = [
            ['id' => 1, 'name' => 'GeenVarken', 'description' => 'Geen Varkensvlees'],
            ['id' => 2, 'name' => 'Veganistisch', 'description' => 'Geen zuivelproducten en vlees'],
            ['id' => 3, 'name' => 'Vegetarisch', 'description' => 'Geen vlees'],
            ['id' => 4, 'name' => 'Omnivoor', 'description' => 'Geen beperkingen'],
        ];

        DB::table('diet_preferences')->insert($dietPreferences);

        // Seed EetwensPerGezin (Diet Preference per Family) table
        $familyDietPreferences = [
            ['id' => 1, 'family_id' => 1, 'diet_preference_id' => 2],
            ['id' => 2, 'family_id' => 2, 'diet_preference_id' => 4],
            ['id' => 3, 'family_id' => 3, 'diet_preference_id' => 4],
            ['id' => 4, 'family_id' => 4, 'diet_preference_id' => 3],
            ['id' => 5, 'family_id' => 5, 'diet_preference_id' => 2],
        ];

        DB::table('diet_preference_per_families')->insert($familyDietPreferences);


        // Seed Voedselpakket (Food Package) table
        $foodPackages = [
            ['id' => 1, 'family_id' => 1, 'package_number' => '1', 'date_composed' => '2024-04-06', 'date_issued' => '2024-04-07', 'status' => 'Uitgereikt'],
            ['id' => 2, 'family_id' => 1, 'package_number' => '2', 'date_composed' => '2024-04-13', 'date_issued' => null, 'status' => 'NietUitgereikt'],
            ['id' => 3, 'family_id' => 1, 'package_number' => '3', 'date_composed' => '2024-04-20', 'date_issued' => null, 'status' => 'NietMeerIngeschreven'],
            ['id' => 4, 'family_id' => 2, 'package_number' => '4', 'date_composed' => '2024-04-06', 'date_issued' => '2024-04-07', 'status' => 'Uitgereikt'],
            ['id' => 5, 'family_id' => 2, 'package_number' => '5', 'date_composed' => '2024-04-13', 'date_issued' => '2024-04-14', 'status' => 'Uitgereikt'],
            ['id' => 6, 'family_id' => 2, 'package_number' => '6', 'date_composed' => '2024-04-20', 'date_issued' => null, 'status' => 'NietUitgereikt'],
        ];

        DB::table('food_packages')->insert($foodPackages);

        // Seed ProductPerVoedselpakket (Product per Food Package) table
        $productPerPackage = [
            ['id' => 1, 'food_package_id' => 1, 'product_id' => 7, 'quantity_units' => 1],
            ['id' => 2, 'food_package_id' => 1, 'product_id' => 8, 'quantity_units' => 2],
            ['id' => 3, 'food_package_id' => 1, 'product_id' => 9, 'quantity_units' => 1],
            ['id' => 4, 'food_package_id' => 2, 'product_id' => 12, 'quantity_units' => 1],
            ['id' => 5, 'food_package_id' => 2, 'product_id' => 13, 'quantity_units' => 2],
            ['id' => 6, 'food_package_id' => 2, 'product_id' => 14, 'quantity_units' => 1],
            ['id' => 7, 'food_package_id' => 3, 'product_id' => 3, 'quantity_units' => 1],
            ['id' => 8, 'food_package_id' => 3, 'product_id' => 4, 'quantity_units' => 1],
            ['id' => 9, 'food_package_id' => 4, 'product_id' => 20, 'quantity_units' => 1],
            ['id' => 10, 'food_package_id' => 4, 'product_id' => 19, 'quantity_units' => 1],
            ['id' => 11, 'food_package_id' => 4, 'product_id' => 21, 'quantity_units' => 1],
            ['id' => 12, 'food_package_id' => 5, 'product_id' => 24, 'quantity_units' => 1],
            ['id' => 13, 'food_package_id' => 5, 'product_id' => 25, 'quantity_units' => 1],
            ['id' => 14, 'food_package_id' => 5, 'product_id' => 26, 'quantity_units' => 1],
            ['id' => 15, 'food_package_id' => 6, 'product_id' => 26, 'quantity_units' => 1],
        ];

        DB::table('product_per_food_packages')->insert($productPerPackage);
    }
}
