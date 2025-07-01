<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class FamilyFoodPackageController extends Controller
{
    /**
     * Display the overview of families with food packages
     */
    public function index(Request $request): View
    {
        // Get all diet preferences for the dropdown
        $dietPreferences = DB::table('diet_preferences')->get();
        
        // Get the selected diet preference from the request
        $selectedDietPreference = $request->input('diet_preference');
        
        try {
            // If a diet preference is selected, use the filter procedure
            if ($selectedDietPreference) {
                $families = DB::select('CALL GetFoodPackagesOverviewByDietPreference(?)', [$selectedDietPreference]);
            } else {
                // Otherwise show all families
                $families = DB::select('CALL GetFoodPackagesOverview()');
            }
        } catch (Exception $e) {
            // Log the error
            Log::error('Failed to call stored procedure: ' . $e->getMessage());
            
            // Fallback to direct query if stored procedure fails
            $query = DB::table('families as f')
                ->leftJoin('people as rep', function($join) {
                    $join->on('rep.family_id', '=', 'f.id')
                         ->where('rep.is_representative', '=', 1);
                })
                ->leftJoin('food_packages as fp', 'f.id', '=', 'fp.family_id')
                ->leftJoin('diet_preference_per_families as dpf', 'f.id', '=', 'dpf.family_id')
                ->leftJoin('diet_preferences as dp', 'dpf.diet_preference_id', '=', 'dp.id');
            
            // Apply diet preference filter if selected
            if ($selectedDietPreference) {
                $query->where('dp.id', '=', $selectedDietPreference);
            }
            
            $families = $query->select(
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
        
        return view('FoodPackages.food-packages', compact('families', 'dietPreferences', 'selectedDietPreference'));
    }

    /**
     * Display the overview of all food packages for volunteers
     */
    public function volunteerIndex(): View
    {
        try {
            // Get all food packages with family information for volunteers
            $packages = DB::table('food_packages as fp')
                ->join('families as f', 'fp.family_id', '=', 'f.id')
                ->leftJoin('people as rep', function($join) {
                    $join->on('rep.family_id', '=', 'f.id')
                        ->where('rep.is_representative', '=', 1);
                })
                ->select(
                    'fp.id',
                    'fp.package_number',
                    'fp.date_composed',
                    'fp.date_issued',
                    'fp.status',
                    'f.id as family_id',
                    'f.name as family_name',
                    DB::raw("CONCAT(
                        rep.first_name,
                        IF(rep.infix IS NULL OR rep.infix = '', '', CONCAT(' ', rep.infix)),
                        ' ',
                        rep.last_name
                    ) as representative_name"),
                    DB::raw('(SELECT COUNT(*) FROM product_per_food_packages WHERE food_package_id = fp.id) as product_count')
                )
                ->orderBy('fp.date_composed', 'desc')
                ->get();
        
            return view('volunteer.food-packages', compact('packages'));
        } catch (Exception $e) {
            Log::error('Failed to get food packages for volunteers: ' . $e->getMessage());
            return view('volunteer.food-packages', [
                'packages' => collect(),
                'error' => 'Er is een fout opgetreden bij het ophalen van de voedselpakketten'
            ]);
        }
    }
}
