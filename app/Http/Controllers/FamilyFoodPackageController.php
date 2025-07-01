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
            // Try using a direct query since the stored procedure has issues
            $families = DB::table('families as f')
                ->leftJoin('people as p', 'f.representative_id', '=', 'p.id')
                ->leftJoin('food_packages as fp', 'f.id', '=', 'fp.family_id')
                ->select(
                    'f.id',
                    'f.name',
                    'f.description',
                    'f.adults',
                    'f.children',
                    'f.babies',
                    'f.representative_id',
                    'p.name as representative_name'
                )
                ->groupBy(
                    'f.id',
                    'f.name',
                    'f.description',
                    'f.adults',
                    'f.children',
                    'f.babies',
                    'f.representative_id',
                    'p.name'
                )
                ->get();
        } catch (Exception $e) {
            Log::error('Error fetching families: ' . $e->getMessage());
            $families = collect(); // Empty collection if there's an error
        }
        
        return view('FoodPackages.food-packages', compact('families'));
    }
}
