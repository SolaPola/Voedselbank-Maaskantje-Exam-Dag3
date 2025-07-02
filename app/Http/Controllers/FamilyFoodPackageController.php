<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class FamilyFoodPackageController extends Controller
{
    // Remove middleware from constructor
    public function __construct()
    {
        // No middleware applied here
    }
    
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
    public function volunteerIndex(Request $request): View
    {
        try {
            // Get all diet preferences for the dropdown
            $dietPreferences = DB::table('diet_preferences')->get();
            
            // Get the selected diet preference from the request
            $selectedDietPreference = $request->input('diet_preference');
            
            // Base query for food packages
            $query = DB::table('food_packages as fp')
                ->join('families as f', 'fp.family_id', '=', 'f.id')
                ->leftJoin('people as rep', function($join) {
                    $join->on('rep.family_id', '=', 'f.id')
                        ->where('rep.is_representative', '=', 1);
                });
                
            // Apply diet preference filter if selected
            if ($selectedDietPreference) {
                $query->join('diet_preference_per_families as dpf', 'f.id', '=', 'dpf.family_id')
                      ->where('dpf.diet_preference_id', '=', $selectedDietPreference);
            }
            
            // Complete the query with select and order
            $packages = $query->select(
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
    
            return view('FoodPackages.volunteer.food-packages', compact('packages', 'dietPreferences', 'selectedDietPreference'));
        } catch (Exception $e) {
            Log::error('Failed to get food packages for volunteers: ' . $e->getMessage());
            return view('FoodPackages.volunteer.food-packages', [
                'packages' => collect(),
                'dietPreferences' => DB::table('diet_preferences')->get(),
                'selectedDietPreference' => null,
                'error' => 'Er is een fout opgetreden bij het ophalen van de voedselpakketten'
            ]);
        }
    }

    /**
     * Show food packages for a specific family
     */
    public function showFamilyPackages($id): View|\Illuminate\Http\RedirectResponse
    {
        try {
            // Get family details
            $family = DB::table('families')
                ->where('id', $id)
                ->first();
                
            if (!$family) {
                return redirect()->route('FoodPackages.food-packages')
                    ->with('error', 'Gezin niet gevonden');
            }
            
            // Get all food packages for the family
            $packages = DB::table('food_packages as fp')
                ->where('fp.family_id', $id)
                ->select(
                    'fp.id',
                    'fp.package_number',
                    'fp.date_composed',
                    'fp.date_issued',
                    'fp.status',
                    DB::raw('(SELECT COUNT(*) FROM product_per_food_packages WHERE food_package_id = fp.id) as product_count')
                )
                ->get();
                
            return view('FoodPackages.family-packages', compact('family', 'packages'));
        } catch (Exception $e) {
            Log::error('Failed to get family packages: ' . $e->getMessage());
            return redirect()->route('FoodPackages.food-packages')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van de voedselpakketten');
        }
    }

    /**
     * Show food packages for a specific family (volunteer version)
     */
    public function volunteerShowFamilyPackages($id)
    {
        try {
            // Get family details
            $family = DB::table('families')
                ->where('id', $id)
                ->first();
                
            if (!$family) {
                return redirect()->route('volunteer.food-packages')
                    ->with('error', 'Gezin niet gevonden');
            }
            
            // Get all food packages for the family
            $packages = DB::table('food_packages as fp')
                ->where('fp.family_id', $id)
                ->select(
                    'fp.id',
                    'fp.package_number',
                    'fp.date_composed',
                    'fp.date_issued',
                    'fp.status',
                    DB::raw('(SELECT COUNT(*) FROM product_per_food_packages WHERE food_package_id = fp.id) as product_count')
                )
                ->get();
                
            return view('FoodPackages.volunteer.family-packages', compact('family', 'packages'));
        } catch (Exception $e) {
            Log::error('Failed to get family packages for volunteer: ' . $e->getMessage());
            return redirect()->route('volunteer.food-packages')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van de voedselpakketten');
        }
    }

    /**
     * Show form to edit food package status
     */
    public function editStatus($id): View|\Illuminate\Http\RedirectResponse
    {
        try {
            // Use stored procedure to get package details
            $results = DB::select('CALL GetFoodPackageForEditing(?)', [$id]);
            
            if (empty($results)) {
                return redirect()->route('FoodPackages.food-packages')
                    ->with('error', 'Voedselpakket niet gevonden');
            }
            
            $package = $results[0];
            
            // Define possible status options
            $statusOptions = [
                'Uitgereikt' => 'Uitgereikt',
                'NietUitgereikt' => 'Niet Uitgereikt',
                'NietMeerIngeschreven' => 'Niet Meer Ingeschreven'
            ];
                
            return view('FoodPackages.edit-status', compact('package', 'statusOptions'));
        } catch (Exception $e) {
            Log::error('Failed to get package for editing: ' . $e->getMessage());
            return redirect()->route('FoodPackages.food-packages')
                ->with('error', 'Er is een fout opgetreden bij het bewerken van het voedselpakket');
        }
    }

    /**
     * Update food package status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'status' => 'required|string|in:Uitgereikt,NietUitgereikt,NietMeerIngeschreven'
            ]);
            
            $newStatus = $request->status;
            
            // First, get the package to check if it exists and get family_id
            $package = DB::table('food_packages')->where('id', $id)->first();
            
            if (!$package) {
                return redirect()->route('FoodPackages.food-packages')
                    ->with('error', 'Voedselpakket niet gevonden');
            }
            
            $familyId = $package->family_id;
            $oldStatus = $package->status;
            
            // Set date_issued if changing to "Uitgereikt"
            $dateIssued = $package->date_issued;
            if ($newStatus === 'Uitgereikt' && $oldStatus !== 'Uitgereikt') {
                $dateIssued = now();
            }
            
            // Update the package status directly instead of using stored procedure
            DB::table('food_packages')
                ->where('id', $id)
                ->update([
                    'status' => $newStatus,
                    'date_issued' => $dateIssued
                ]);
        
            // Session flash message for the 3-second display
            return redirect()->route('food-packages.family', $familyId)
                ->with('success', 'De wijziging is doorgevoerd')
                ->with('status_changed', [
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'package_id' => $id
                ]);
        } catch (Exception $e) {
            Log::error('Failed to update package status: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het bijwerken van het voedselpakket');
        }
    }

    /**
     * Show form to edit food package status (for volunteers)
     */
    public function volunteerEditStatus($id)
    {
        try {
            // Get food package details without using is_active column
            $package = DB::table('food_packages as fp')
                ->join('families as f', 'fp.family_id', '=', 'f.id')
                ->where('fp.id', $id)
                ->select(
                    'fp.id',
                    'fp.package_number',
                    'fp.date_composed',
                    'fp.date_issued',
                    'fp.status',
                    'f.id as family_id',
                    'f.name as family_name'
                )
                ->first();
                
            if (!$package) {
                return redirect()->route('volunteer.food-packages')
                    ->with('error', 'Voedselpakket niet gevonden');
            }
            
            // Define possible status options
            $statusOptions = [
                'Uitgereikt' => 'Uitgereikt',
                'NietUitgereikt' => 'Niet Uitgereikt',
                'NietMeerIngeschreven' => 'Niet Meer Ingeschreven'
            ];
            
            // Check if package status is already "NietMeerIngeschreven"
            $isDisabled = false;
            $errorMessage = null;
            
            if ($package->status === 'NietMeerIngeschreven') {
                $isDisabled = true;
                $errorMessage = 'Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt';
            }
            
            return view('FoodPackages.volunteer.edit-status', compact('package', 'statusOptions', 'isDisabled', 'errorMessage'));
        } catch (Exception $e) {
            Log::error('Failed to get package for editing: ' . $e->getMessage());
            return redirect()->route('volunteer.food-packages')
                ->with('error', 'Er is een fout opgetreden bij het bewerken van het voedselpakket');
        }
    }

    /**
     * Update food package status for volunteers
     */
    public function volunteerUpdateStatus(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'status' => 'required|string|in:Uitgereikt,NietUitgereikt,NietMeerIngeschreven'
            ]);
            
            // Get the food package
            $package = DB::table('food_packages')->where('id', $id)->first();
            
            if (!$package) {
                return redirect()->route('volunteer.food-packages')
                    ->with('error', 'Voedselpakket niet gevonden');
            }
            
            $oldStatus = $package->status;
            $newStatus = $request->status;
            
            // Only set date_issued if changing to "Uitgereikt" status
            $dateIssued = $package->date_issued;
            if ($newStatus === 'Uitgereikt' && $oldStatus !== 'Uitgereikt') {
                $dateIssued = now();
            }
            
            // Update the package status with a direct query
            DB::table('food_packages')
                ->where('id', $id)
                ->update([
                    'status' => $newStatus,
                    'date_issued' => $dateIssued
                ]);
            
            // Show success message on the same page
            return redirect()->route('volunteer.food-packages.edit', $id)
                ->with('success', 'De wijziging is doorgevoerd');
                
            // After 3 seconds, redirect back to family packages page
            // This is handled via JavaScript in the view
        } catch (Exception $e) {
            Log::error('Failed to update package status: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het bijwerken van het voedselpakket');
        }
    }
}
