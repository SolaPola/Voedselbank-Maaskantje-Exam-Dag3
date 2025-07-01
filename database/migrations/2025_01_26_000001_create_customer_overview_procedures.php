<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create procedure for getting total count
        DB::unprepared('
            CREATE PROCEDURE GetCustomerOverviewCount()
            BEGIN
                SELECT COUNT(*) as total_count
                FROM families f
                WHERE f.isactive = 1;
            END
        ');

        // Create procedure for paginated results
        DB::unprepared('
            CREATE PROCEDURE GetCustomerOverviewPaginated(IN offset_param INT, IN limit_param INT)
            BEGIN
                SELECT 
                    f.id,
                    f.name as family_name,
                    CONCAT(
                        COALESCE(p.first_name, ""), 
                        CASE 
                            WHEN p.infix IS NOT NULL AND p.infix != "" THEN CONCAT(" ", p.infix, " ") 
                            ELSE " " 
                        END,
                        COALESCE(p.last_name, "")
                    ) as representative_name,
                    c.email,
                    c.mobile,
                    CONCAT(
                        COALESCE(c.street, ""), " ", 
                        COALESCE(c.house_number, ""),
                        CASE 
                            WHEN c.addition IS NOT NULL AND c.addition != "" THEN CONCAT(" ", c.addition) 
                            ELSE "" 
                        END
                    ) as address,
                    c.city
                FROM families f
                LEFT JOIN people p ON f.id = p.family_id AND p.is_representative = 1 AND p.isactive = 1
                LEFT JOIN contact_per_families cpf ON f.id = cpf.family_id AND cpf.isactive = 1
                LEFT JOIN contacts c ON cpf.contact_id = c.id AND c.isactive = 1
                WHERE f.isactive = 1
                ORDER BY f.name
                LIMIT limit_param OFFSET offset_param;
            END
        ');

        // Create original procedure for backward compatibility
        DB::unprepared('
            CREATE PROCEDURE GetCustomerOverview()
            BEGIN
                SELECT 
                    f.id,
                    f.name as family_name,
                    CONCAT(
                        COALESCE(p.first_name, ""), 
                        CASE 
                            WHEN p.infix IS NOT NULL AND p.infix != "" THEN CONCAT(" ", p.infix, " ") 
                            ELSE " " 
                        END,
                        COALESCE(p.last_name, "")
                    ) as representative_name,
                    c.email,
                    c.mobile,
                    CONCAT(
                        COALESCE(c.street, ""), " ", 
                        COALESCE(c.house_number, ""),
                        CASE 
                            WHEN c.addition IS NOT NULL AND c.addition != "" THEN CONCAT(" ", c.addition) 
                            ELSE "" 
                        END
                    ) as address,
                    c.city
                FROM families f
                LEFT JOIN people p ON f.id = p.family_id AND p.is_representative = 1 AND p.isactive = 1
                LEFT JOIN contact_per_families cpf ON f.id = cpf.family_id AND cpf.isactive = 1
                LEFT JOIN contacts c ON cpf.contact_id = c.id AND c.isactive = 1
                WHERE f.isactive = 1
                ORDER BY f.name;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCustomerOverviewCount');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCustomerOverviewPaginated');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCustomerOverview');
    }
};
