<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create GetFoodPackageForEditing stored procedure
        DB::unprepared("
        DROP PROCEDURE IF EXISTS GetFoodPackageForEditing;
            CREATE PROCEDURE GetFoodPackageForEditing(IN package_id INT)
            BEGIN
                SELECT 
                    fp.id,
                    fp.package_number,
                    fp.date_composed,
                    fp.date_issued,
                    fp.status,
                    f.id as family_id,
                    f.name as family_name
                FROM food_packages fp
                JOIN families f ON fp.family_id = f.id
                WHERE fp.id = package_id;
            END
        ");
        
        // Create UpdateFoodPackageStatus stored procedure
        DB::unprepared("
        DROP PROCEDURE IF EXISTS UpdateFoodPackageStatus;
            CREATE PROCEDURE UpdateFoodPackageStatus(
                IN package_id INT,
                IN new_status VARCHAR(50)
            )
            BEGIN
                DECLARE date_issued DATETIME;
                SET date_issued = NULL;
                
                IF new_status = 'Uitgereikt' THEN
                    SET date_issued = NOW();
                END IF;
                
                UPDATE food_packages 
                SET status = new_status, 
                    date_issued = date_issued
                WHERE id = package_id;
                
                SELECT family_id FROM food_packages WHERE id = package_id;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS GetFoodPackageForEditing");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateFoodPackageStatus");
    }
};