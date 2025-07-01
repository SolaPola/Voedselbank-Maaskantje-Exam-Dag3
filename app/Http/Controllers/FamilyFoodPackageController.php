<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Exception;
use Illuminate\Support\Facades\Log;

class FamilyFoodPackageController extends Controller
{
    /**
     * Display the overview of families with food packages
     */
    public function index(): View
    {
        try {
            // Call the stored procedure to get food packages overview
            $families = DB::select('CALL GetFoodPackagesOverview()');
        } catch (Exception $e) {
            // Log the error
            Log::error('Failed to call GetFoodPackagesOverview procedure: ' . $e->getMessage());
            
            // Fallback to direct query if stored procedure fails
            $families = DB::table('families as f')
                ->leftJoin('people as rep', function($join) {
                    $join->on('rep.family_id', '=', 'f.id')
                         ->where('rep.is_representative', '=', 1);
                })
                ->leftJoin('food_packages as fp', 'f.id', '=', 'fp.family_id')
                ->leftJoin('diet_preference_per_families as dpf', 'f.id', '=', 'dpf.family_id')
                ->leftJoin('diet_preferences as dp', 'dpf.diet_preference_id', '=', 'dp.id')
                ->select(
                    'f.id',
                    'f.name',
                    'f.description',
                    'f.number_of_adults as adults',
                    'f.number_of_children as children',
                    'f.number_of_babies as babies',
                    'f.total_number_of_people as total_people',
                    DB::raw("CONCAT(
                        rep.first_name,
                        IF(rep.infix IS NULL OR rep.infix = '', '', CONCAT(' ', rep.infix)),
                        ' ',
                        rep.last_name
                    ) as representative_name"),
                    DB::raw('COUNT(fp.id) as package_count')
                )
                ->groupBy(
                    'f.id',
                    'f.name',
                    'f.description',
                    'f.number_of_adults',
                    'f.number_of_children',
                    'f.number_of_babies',
                    'f.total_number_of_people',
                    'rep.first_name',
                    'rep.infix',
                    'rep.last_name'
                )
                ->get();
        }
        
        return view('FoodPackages.food-packages', compact('families'));
    }
}
