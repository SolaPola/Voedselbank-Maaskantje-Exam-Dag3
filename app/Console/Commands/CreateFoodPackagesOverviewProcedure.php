<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateFoodPackagesOverviewProcedure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create-food-packages-overview-procedure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the GetFoodPackagesOverview stored procedure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Drop procedure if it exists
            DB::unprepared('DROP PROCEDURE IF EXISTS `GetFoodPackagesOverview`');
            
            // Create the stored procedure
            $procedure = "
                CREATE PROCEDURE `GetFoodPackagesOverview`()
                BEGIN
                    SELECT 
                        f.id,
                        f.name,
                        f.description,
                        f.number_of_adults as adults,
                        f.number_of_children as children,
                        f.number_of_babies as babies,
                        f.total_number_of_people as total_people,
                        p.first_name as representative_first_name,
                        p.infix as representative_infix,
                        p.last_name as representative_last_name,
                        CONCAT(
                            p.first_name,
                            IF(p.infix IS NULL OR p.infix = '', '', CONCAT(' ', p.infix)),
                            ' ',
                            p.last_name
                        ) as representative_name,
                        COUNT(fp.id) as package_count,
                        MAX(fp.date_composed) as latest_package_date,
                        GROUP_CONCAT(DISTINCT dp.name SEPARATOR ', ') as diet_preferences
                    FROM 
                        families f
                    LEFT JOIN 
                        people p ON f.representative_id = p.id AND p.is_representative = 1
                    LEFT JOIN 
                        food_packages fp ON f.id = fp.family_id
                    LEFT JOIN
                        diet_preference_per_families dpf ON f.id = dpf.family_id
                    LEFT JOIN
                        diet_preferences dp ON dpf.diet_preference_id = dp.id
                    GROUP BY 
                        f.id, f.name, f.description, f.number_of_adults, f.number_of_children, 
                        f.number_of_babies, f.total_number_of_people, p.first_name, p.infix, p.last_name;
                END
            ";
            
            DB::unprepared($procedure);
            
            $this->info('Stored procedure created successfully.');
        } catch (\Exception $e) {
            $this->error('Failed to create stored procedure: ' . $e->getMessage());
        }
    }
}
