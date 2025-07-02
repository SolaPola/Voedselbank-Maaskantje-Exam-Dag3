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
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetProductStockOverviewByCategory;

            CREATE PROCEDURE GetProductStockOverviewByCategory(IN categoryId INT)
            BEGIN
                SELECT 
                    p.id as product_id,
                    p.name as product_name,
                    c.name as category_name,
                    w.packaging_unit,
                    w.quantity,
                    ppw.location,
                    p.status,
                    p.expiry_date
                FROM products p
                INNER JOIN categories c ON p.category_id = c.id
                INNER JOIN product_per_warehouses ppw ON p.id = ppw.product_id
                INNER JOIN warehouses w ON ppw.warehouse_id = w.id
                WHERE p.isactive = 1 
                AND c.isactive = 1 
                AND w.isactive = 1 
                AND ppw.isactive = 1
                AND c.id = categoryId
                ORDER BY p.name, c.name;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetProductStockOverviewByCategory');
    }
};
    