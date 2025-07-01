<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\Person;
use App\Models\Contact;
use App\Models\ContactPerFamily;
use Illuminate\Support\Facades\DB;

/**
 * CustomerController handles all CRUD operations for customer management
 * This includes viewing, editing, and updating customer information
 */
class CustomerController extends Controller
{
    /**
     * Display a paginated listing of customers with postal code filtering
     * Uses stored procedures for efficient database queries
     */
    public function index(Request $request)
    {
        // Set up pagination parameters
        $page = $request->get('page', 1);
        $perPage = 10; // Show 10 customers per page
        $offset = ($page - 1) * $perPage;
        $postalCode = $request->get('postal_code'); // Optional postal code filter

        // Get total count using stored procedure with optional postal code filter
        $totalCount = DB::select('CALL GetCustomerOverviewCount(?)', [$postalCode])[0]->total_count;
        
        // Get paginated customer data using stored procedure
        // Returns families with representative and contact information
        $families = DB::select('CALL GetCustomerOverviewPaginated(?, ?, ?)', [$offset, $perPage, $postalCode]);
        
        // Convert to Laravel collection for easier manipulation
        $families = collect($families);
        
        // Create manual pagination object since we're using stored procedures
        $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
            $families,           // Items for current page
            $totalCount,         // Total number of items
            $perPage,           // Items per page
            $page,              // Current page number
            ['path' => request()->url(), 'pageName' => 'page'] // URL configuration
        );

        // Return the customer index view with pagination data
        return view('customer.index', compact('pagination'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display detailed information for a specific customer
     * Shows all personal and contact details in read-only format
     */
    public function show(string $id)
    {
        // Load family with representative person and contact information
        $family = Family::with([
            'people' => function($query) {
                $query->where('is_representative', true); // Only get the representative
            },
            'contactPerFamilies.contact' // Load contact details through pivot table
        ])->findOrFail($id);

        // Extract representative and contact for easier use in view
        $representative = $family->people->first();
        $contact = $family->contactPerFamilies->first()?->contact;

        return view('customer.show', compact('family', 'representative', 'contact'));
    }

    /**
     * Show the form for editing customer information
     * Loads the same data as show() but renders an editable form
     */
    public function edit(string $id)
    {
        // Load family with representative and contact data for editing
        $family = Family::with([
            'people' => function($query) {
                $query->where('is_representative', true);
            },
            'contactPerFamilies.contact'
        ])->findOrFail($id);

        return view('customer.edit', compact('family'));
    }

    /**
     * Update customer information with comprehensive validation
     * Handles both personal information (Person) and contact details (Contact)
     */
    public function update(Request $request, string $id)
    {
        // Comprehensive validation with regex patterns to prevent malicious input
        $validatedData = $request->validate([
            // Personal information validation
            'first_name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/'],
            'infix' => ['nullable', 'string', 'max:20', 'regex:/^[a-zA-ZÀ-ÿ\s\'-]*$/'],
            'last_name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/'],
            'date_of_birth' => ['nullable', 'date', 'after:1900-01-01', 'before:today'],
            
            // Contact information validation
            'email' => 'required|email|max:255',
            'mobile' => ['required', 'string', 'min:10', 'max:20', 'regex:/^[0-9+\-\s()]*$/'],
            'street' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ0-9\s\'-\.]+$/'],
            'house_number' => ['required', 'string', 'min:1', 'max:10', 'regex:/^[0-9a-zA-Z\-]*$/'],
            
            // Postal code validation with custom rule for Maaskantje region
            'postal_code' => ['required', 'string', function ($attribute, $value, $fail) {
                $allowedPostalCodes = ['5271TH', '5271TJ', '5271ZE', '5271ZH'];
                if (!in_array($value, $allowedPostalCodes)) {
                    $fail('Deze postcode komt niet uit de regio Maaskantje');
                }
            }],
            'city' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/'],
            'addition' => ['nullable', 'string', 'max:10', 'regex:/^[a-zA-Z0-9\-]*$/'],
        ], [
            // Custom Dutch error messages for better user experience
            'first_name.required' => 'Voornaam is verplicht',
            'first_name.min' => 'Voornaam moet minimaal 2 tekens bevatten',
            'first_name.max' => 'Voornaam mag maximaal 50 tekens bevatten',
            'first_name.regex' => 'Voornaam mag alleen letters, spaties, apostrofes en koppeltekens bevatten',
            'infix.max' => 'Tussenvoegsel mag maximaal 20 tekens bevatten',
            'infix.regex' => 'Tussenvoegsel mag alleen letters, spaties, apostrofes en koppeltekens bevatten',
            'last_name.required' => 'Achternaam is verplicht',
            'last_name.min' => 'Achternaam moet minimaal 2 tekens bevatten',
            'last_name.max' => 'Achternaam mag maximaal 50 tekens bevatten',
            'last_name.regex' => 'Achternaam mag alleen letters, spaties, apostrofes en koppeltekens bevatten',
            'date_of_birth.after' => 'Geboortedatum moet na 1900 zijn',
            'date_of_birth.before' => 'Geboortedatum kan niet in de toekomst liggen',
            'email.required' => 'E-mail is verplicht',
            'email.email' => 'E-mail moet een geldig e-mailadres zijn',
            'mobile.required' => 'Mobiel nummer is verplicht',
            'mobile.min' => 'Mobiel nummer moet minimaal 10 tekens bevatten',
            'mobile.regex' => 'Mobiel nummer mag alleen cijfers, spaties, + - ( ) bevatten',
            'street.required' => 'Straatnaam is verplicht',
            'street.min' => 'Straatnaam moet minimaal 2 tekens bevatten',
            'street.regex' => 'Straatnaam mag alleen letters, cijfers, spaties en enkele leestekens bevatten',
            'house_number.required' => 'Huisnummer is verplicht',
            'house_number.regex' => 'Huisnummer mag alleen cijfers, letters en koppeltekens bevatten',
            'postal_code.required' => 'Postcode is verplicht',
            'city.required' => 'Woonplaats is verplicht',
            'city.min' => 'Woonplaats moet minimaal 2 tekens bevatten',
            'city.regex' => 'Woonplaats mag alleen letters, spaties, apostrofes en koppeltekens bevatten',
            'addition.regex' => 'Toevoeging mag alleen letters, cijfers en koppeltekens bevatten',
        ]);

        // Find the family record
        $family = Family::findOrFail($id);
        $contactPerFamily = $family->contactPerFamilies()->first();
        
        // Update contact information through the contact relationship
        if ($contactPerFamily && $contactPerFamily->contact) {
            $contactPerFamily->contact->update([
                'email' => $validatedData['email'],
                'mobile' => $validatedData['mobile'],
                'street' => $validatedData['street'],
                'house_number' => $validatedData['house_number'],
                'addition' => $validatedData['addition'],
                'postal_code' => $validatedData['postal_code'],
                'city' => $validatedData['city'],
            ]);
        }

        // Update personal information for the family representative
        $representative = $family->people()->where('is_representative', true)->first();
        if ($representative) {
            $representative->update([
                'first_name' => $validatedData['first_name'],
                'infix' => $validatedData['infix'],
                'last_name' => $validatedData['last_name'],
                'date_of_birth' => $validatedData['date_of_birth'],
            ]);
        }

        // Redirect to show page with success message
        return redirect()->route('customers.show', $id)->with('success', 'De klantgegevens zijn gewijzigd');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
