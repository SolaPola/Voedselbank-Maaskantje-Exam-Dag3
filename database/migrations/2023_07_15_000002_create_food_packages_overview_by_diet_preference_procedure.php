<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop procedure if it exists to avoid errors
        DB::unprepared('DROP PROCEDURE IF EXISTS `GetFoodPackagesOverviewByDietPreference`');

        // Create the stored procedure for food packages overview filtered by diet preference
        $procedure = "
            CREATE PROCEDURE GetFoodPackagesOverviewByDietPreference(IN diet_preference_id INT)
          BEGIN
              SELECT 
                  f.id,
                  f.name,
                  f.description,
                  f.number_of_adults as adults,
                  f.number_of_children as children,
                  f.number_of_babies as babies,
                  f.total_number_of_people as total_people,
                  CONCAT(
                      rep.first_name,
                      IF(rep.infix IS NULL OR rep.infix = '', '', CONCAT(' ', rep.infix)),' ',
                      rep.last_name) as representative_name,
                  COUNT(fp.id) as package_count,
                  MAX(fp.date_composed) as latest_package_date,
                  GROUP_CONCAT(DISTINCT dp.name SEPARATOR ', ') as diet_preferences
              FROM
                  
families f
                INNER JOIN
                    diet_preference_per_families dpf ON f.id = dpf.family_id
                INNER JOIN
                    diet_preferences dp ON dpf.diet_preference_id = dp.id
                LEFT JOIN 
                    people rep ON rep.family_id = f.id AND rep.is_representative = 1
                LEFT JOIN 
                    food_packages fp ON f.id = fp.family_id
                WHERE
                    dp.id = diet_preference_id
                GROUP BY 
                    f.id, f.name, f.description, f.number_of_adults, f.number_of_children, 
                    f.number_of_babies, f.total_number_of_people, rep.first_name, rep.infix, rep.last_name;
            END
        ";

        DB::unprepared($procedure);
    }
    /*Reverse the migrations.*/
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetFoodPackagesOverviewByDietPreference');
    }
};