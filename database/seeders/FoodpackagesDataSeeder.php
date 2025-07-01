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
        // Seed Gezin (Family) table
        $families = [
            ['id' => 1, 'name' => 'ZevenhuizenGezin', 'code' => 'G0001', 'description' => 'Bijstandsgezin', 'number_of_adults' => 2, 'number_of_children' => 2, 'number_of_babies' => 0, 'total_number_of_people' => 4],
            ['id' => 2, 'name' => 'BergkampGezin', 'code' => 'G0002', 'description' => 'Bijstandsgezin', 'number_of_adults' => 2, 'number_of_children' => 1, 'number_of_babies' => 1, 'total_number_of_people' => 4],
            ['id' => 3, 'name' => 'HeuvelGezin', 'code' => 'G0003', 'description' => 'Bijstandsgezin', 'number_of_adults' => 2, 'number_of_children' => 0, 'number_of_babies' => 0, 'total_number_of_people' => 2],
            ['id' => 4, 'name' => 'ScherderGezin', 'code' => 'G0004', 'description' => 'Bijstandsgezin', 'number_of_adults' => 1, 'number_of_children' => 0, 'number_of_babies' => 2, 'total_number_of_people' => 3],
            ['id' => 5, 'name' => 'DeJongGezin', 'code' => 'G0005', 'description' => 'Bijstandsgezin', 'number_of_adults' => 1, 'number_of_children' => 1, 'number_of_babies' => 0, 'total_number_of_people' => 2],
            ['id' => 6, 'name' => 'VanderBergGezin', 'code' => 'G0006', 'description' => 'AlleenGaande', 'number_of_adults' => 1, 'number_of_children' => 0, 'number_of_babies' => 0, 'total_number_of_people' => 1],
        ];

        DB::table('families')->insert($families);

        // Seed Persoon (Person) table
        $people = [
            ['id' => 1, 'family_id' => null, 'first_name' => 'Hans', 'infix' => 'van', 'last_name' => 'Leeuwen', 'date_of_birth' => '1958-02-12', 'person_type' => 'Manager', 'is_representative' => 0],
            ['id' => 2, 'family_id' => null, 'first_name' => 'Jan', 'infix' => 'van der', 'last_name' => 'Sluijs', 'date_of_birth' => '1993-04-30', 'person_type' => 'Medewerker', 'is_representative' => 0],
            ['id' => 3, 'family_id' => null, 'first_name' => 'Herman', 'infix' => 'den', 'last_name' => 'Duiker', 'date_of_birth' => '1989-08-30', 'person_type' => 'Vrijwilliger', 'is_representative' => 0],
            ['id' => 4, 'family_id' => 1, 'first_name' => 'Johan', 'infix' => 'van', 'last_name' => 'Zevenhuizen', 'date_of_birth' => '1990-05-20', 'person_type' => 'Klant', 'is_representative' => 1],
            ['id' => 5, 'family_id' => 1, 'first_name' => 'Sarah', 'infix' => 'den', 'last_name' => 'Dolder', 'date_of_birth' => '1985-03-23', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 6, 'family_id' => 1, 'first_name' => 'Theo', 'infix' => 'van', 'last_name' => 'Zevenhuizen', 'date_of_birth' => '2015-03-08', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 7, 'family_id' => 1, 'first_name' => 'Jantien', 'infix' => 'van', 'last_name' => 'Zevenhuizen', 'date_of_birth' => '2016-09-20', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 8, 'family_id' => 2, 'first_name' => 'Arjan', 'infix' => null, 'last_name' => 'Bergkamp', 'date_of_birth' => '1968-07-12', 'person_type' => 'Klant', 'is_representative' => 1],
            ['id' => 9, 'family_id' => 2, 'first_name' => 'Janneke', 'infix' => null, 'last_name' => 'Sanders', 'date_of_birth' => '1969-05-11', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 10, 'family_id' => 2, 'first_name' => 'Stein', 'infix' => null, 'last_name' => 'Bergkamp', 'date_of_birth' => '2009-02-02', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 11, 'family_id' => 2, 'first_name' => 'Judith', 'infix' => null, 'last_name' => 'Bergkamp', 'date_of_birth' => '2022-02-05', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 12, 'family_id' => 3, 'first_name' => 'Mazin', 'infix' => 'van', 'last_name' => 'Vliet', 'date_of_birth' => '1968-08-18', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 13, 'family_id' => 3, 'first_name' => 'Selma', 'infix' => 'van de', 'last_name' => 'Heuvel', 'date_of_birth' => '1965-09-04', 'person_type' => 'Klant', 'is_representative' => 1],
            ['id' => 14, 'family_id' => 4, 'first_name' => 'Eva', 'infix' => null, 'last_name' => 'Scherder', 'date_of_birth' => '2000-04-07', 'person_type' => 'Klant', 'is_representative' => 1],
            ['id' => 15, 'family_id' => 4, 'first_name' => 'Felicia', 'infix' => null, 'last_name' => 'Scherder', 'date_of_birth' => '2021-11-29', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 16, 'family_id' => 4, 'first_name' => 'Devin', 'infix' => null, 'last_name' => 'Scherder', 'date_of_birth' => '2024-03-01', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 17, 'family_id' => 5, 'first_name' => 'Frieda', 'infix' => 'de', 'last_name' => 'Jong', 'date_of_birth' => '1980-09-04', 'person_type' => 'Klant', 'is_representative' => 1],
            ['id' => 18, 'family_id' => 5, 'first_name' => 'Simeon', 'infix' => 'de', 'last_name' => 'Jong', 'date_of_birth' => '2018-05-23', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 19, 'family_id' => 6, 'first_name' => 'Hanna', 'infix' => 'van der', 'last_name' => 'Berg', 'date_of_birth' => '1999-09-09', 'person_type' => 'Klant', 'is_representative' => 1],
        ];

        DB::table('people')->insert($people);

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

        // Seed products table using the migration column names
        // Fixed duplicate barcodes by adding product ID to make them unique
        $products = [
            ['id' => 1, 'name' => 'Aardappel', 'category_id' => 1, 'allergy_type' => null, 'barcode' => '8719587321239-1', 'expiry_date' => '2024-07-12', 'description' => 'Kruimige aardappel', 'status' => 'OpVoorraad'],
            ['id' => 2, 'name' => 'Aardappel', 'category_id' => 1, 'allergy_type' => null, 'barcode' => '8719587321239-2', 'expiry_date' => '2024-07-26', 'description' => 'Kruimige aardappel', 'status' => 'OpVoorraad'],
            ['id' => 3, 'name' => 'Ui', 'category_id' => 1, 'allergy_type' => null, 'barcode' => '8719437321335', 'expiry_date' => '2024-09-02', 'description' => 'Gele ui', 'status' => 'NietOpVoorraad'],
            ['id' => 4, 'name' => 'Appel', 'category_id' => 1, 'allergy_type' => null, 'barcode' => '8719486321332-1', 'expiry_date' => '2024-08-16', 'description' => 'Granny Smith', 'status' => 'NietLeverbaar'],
            ['id' => 5, 'name' => 'Appel', 'category_id' => 1, 'allergy_type' => null, 'barcode' => '8719486321332-2', 'expiry_date' => '2024-09-23', 'description' => 'Granny Smith', 'status' => 'NietLeverbaar'],
            ['id' => 6, 'name' => 'Banaan', 'category_id' => 1, 'allergy_type' => 'Banaan', 'barcode' => '8719484321336-1', 'expiry_date' => '2024-07-12', 'description' => 'Biologische Banaan', 'status' => 'OverHoudbaarheidsDatum'],
            ['id' => 7, 'name' => 'Banaan', 'category_id' => 1, 'allergy_type' => 'Banaan', 'barcode' => '8719484321336-2', 'expiry_date' => '2024-07-19', 'description' => 'Biologische Banaan', 'status' => 'OverHoudbaarheidsDatum'],
            ['id' => 8, 'name' => 'Kaas', 'category_id' => 2, 'allergy_type' => 'Lactose', 'barcode' => '8719487421338', 'expiry_date' => '2024-09-19', 'description' => 'Jonge Kaas', 'status' => 'OpVoorraad'],
            ['id' => 9, 'name' => 'Rosbief', 'category_id' => 2, 'allergy_type' => null, 'barcode' => '8719487421331', 'expiry_date' => '2024-07-23', 'description' => 'Rundvlees', 'status' => 'OpVoorraad'],
            ['id' => 10, 'name' => 'Melk', 'category_id' => 3, 'allergy_type' => 'Lactose', 'barcode' => '8719447321332', 'expiry_date' => '2024-07-23', 'description' => 'Halfvolle melk', 'status' => 'OpVoorraad'],
            ['id' => 11, 'name' => 'Margarine', 'category_id' => 3, 'allergy_type' => null, 'barcode' => '8719486321336-3', 'expiry_date' => '2024-08-02', 'description' => 'Plantaardige boter', 'status' => 'OpVoorraad'],
            ['id' => 12, 'name' => 'Ei', 'category_id' => 3, 'allergy_type' => 'Eier', 'barcode' => '8719487421334', 'expiry_date' => '2024-08-04', 'description' => 'Scharrelei', 'status' => 'OpVoorraad'],
            ['id' => 13, 'name' => 'Brood', 'category_id' => 4, 'allergy_type' => 'Gluten', 'barcode' => '8719487721337', 'expiry_date' => '2024-07-07', 'description' => 'Volkoren brood', 'status' => 'OpVoorraad'],
            ['id' => 14, 'name' => 'Gevulde Koek', 'category_id' => 4, 'allergy_type' => 'Amandel', 'barcode' => '8719483321333', 'expiry_date' => '2024-09-04', 'description' => 'Banketbakkers kwaliteit', 'status' => 'OpVoorraad'],
            ['id' => 15, 'name' => 'Fristi', 'category_id' => 5, 'allergy_type' => 'Lactose', 'barcode' => '8719487121331', 'expiry_date' => '2024-10-28', 'description' => 'Frisdrank', 'status' => 'NietOpVoorraad'],
            ['id' => 16, 'name' => 'Appelsap', 'category_id' => 5, 'allergy_type' => null, 'barcode' => '8719487521335', 'expiry_date' => '2024-10-19', 'description' => '100% vruchtensap', 'status' => 'OpVoorraad'],
            ['id' => 17, 'name' => 'Koffie', 'category_id' => 5, 'allergy_type' => 'Cafeine', 'barcode' => '8719487381338', 'expiry_date' => '2024-10-23', 'description' => 'Arabica koffie', 'status' => 'OverHoudbaarheidsDatum'],
            ['id' => 18, 'name' => 'Thee', 'category_id' => 5, 'allergy_type' => 'Theine', 'barcode' => '8719487329339', 'expiry_date' => '2024-09-02', 'description' => 'Ceylon thee', 'status' => 'OpVoorraad'],
            ['id' => 19, 'name' => 'Pasta', 'category_id' => 6, 'allergy_type' => 'Gluten', 'barcode' => '8719487321334', 'expiry_date' => '2024-12-16', 'description' => 'Macaroni', 'status' => 'NietLeverbaar'],
            ['id' => 20, 'name' => 'Rijst', 'category_id' => 6, 'allergy_type' => null, 'barcode' => '8719487331332', 'expiry_date' => '2024-12-25', 'description' => 'Basmati Rijst', 'status' => 'OpVoorraad'],
            ['id' => 21, 'name' => 'Knorr Nasi Mix', 'category_id' => 6, 'allergy_type' => null, 'barcode' => '8719487351335', 'expiry_date' => '2024-12-13', 'description' => 'Nasi kruiden', 'status' => 'OpVoorraad'],
            ['id' => 22, 'name' => 'Tomatensoep', 'category_id' => 7, 'allergy_type' => null, 'barcode' => '8719487371337', 'expiry_date' => '2024-12-23', 'description' => 'Romige tomatensoep', 'status' => 'OpVoorraad'],
            ['id' => 23, 'name' => 'Tomatensaus', 'category_id' => 7, 'allergy_type' => null, 'barcode' => '8719487341334', 'expiry_date' => '2024-12-21', 'description' => 'Pizza saus', 'status' => 'NietOpVoorraad'],
            ['id' => 24, 'name' => 'Peterselie', 'category_id' => 7, 'allergy_type' => null, 'barcode' => '8719487321636', 'expiry_date' => '2024-07-31', 'description' => 'Verse kruidenpot', 'status' => 'OpVoorraad'],
            ['id' => 25, 'name' => 'Olie', 'category_id' => 8, 'allergy_type' => null, 'barcode' => '8719487327337', 'expiry_date' => '2024-12-27', 'description' => 'Olijfolie', 'status' => 'OpVoorraad'],
            ['id' => 26, 'name' => 'Mars', 'category_id' => 8, 'allergy_type' => null, 'barcode' => '8719487324334', 'expiry_date' => '2024-12-11', 'description' => 'Snoep', 'status' => 'OpVoorraad'],
            ['id' => 27, 'name' => 'Biscuit', 'category_id' => 8, 'allergy_type' => null, 'barcode' => '8719487311331', 'expiry_date' => '2024-08-07', 'description' => 'San Francisco biscuit', 'status' => 'OpVoorraad'],
            ['id' => 28, 'name' => 'Paprika Chips', 'category_id' => 8, 'allergy_type' => null, 'barcode' => '8719487321839', 'expiry_date' => '2024-12-22', 'description' => 'Ribbelchips paprika', 'status' => 'OpVoorraad'],
            ['id' => 29, 'name' => 'Chocolade reep', 'category_id' => 8, 'allergy_type' => 'Cacao', 'barcode' => '8719487321533', 'expiry_date' => '2024-11-21', 'description' => 'Tony Chocolonely', 'status' => 'OpVoorraad'],
        ];

        DB::table('products')->insert($products);

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
