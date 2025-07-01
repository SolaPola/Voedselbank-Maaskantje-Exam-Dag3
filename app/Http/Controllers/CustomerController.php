<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\Person;
use App\Models\Contact;
use App\Models\ContactPerFamily;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $postalCode = $request->get('postal_code');

        // Get total count with postal code filter
        $totalCount = DB::select('CALL GetCustomerOverviewCount(?)', [$postalCode])[0]->total_count;
        
        // Get paginated data using stored procedure with postal code filter
        $families = DB::select('CALL GetCustomerOverviewPaginated(?, ?, ?)', [$offset, $perPage, $postalCode]);
        
        // Convert to collection for easier manipulation
        $families = collect($families);
        
        // Create pagination manually
        $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
            $families,
            $totalCount,
            $perPage,
            $page,
            ['path' => request()->url(), 'pageName' => 'page']
        );

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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $family = Family::with([
            'people' => function($query) {
                $query->where('is_representative', true);
            },
            'contactPerFamilies.contact'
        ])->findOrFail($id);

        $representative = $family->people->first();
        $contact = $family->contactPerFamilies->first()?->contact;

        return view('customer.show', compact('family', 'representative', 'contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $family = Family::with([
            'people' => function($query) {
                $query->where('is_representative', true);
            },
            'contactPerFamilies.contact'
        ])->findOrFail($id);

        return view('customer.edit', compact('family'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/'],
            'infix' => ['nullable', 'string', 'max:20', 'regex:/^[a-zA-ZÀ-ÿ\s\'-]*$/'],
            'last_name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/'],
            'date_of_birth' => ['nullable', 'date', 'after:1900-01-01', 'before:today'],
            'email' => 'required|email|max:255',
            'mobile' => ['required', 'string', 'min:10', 'max:20', 'regex:/^[0-9+\-\s()]*$/'],
            'street' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ0-9\s\'-\.]+$/'],
            'house_number' => ['required', 'string', 'min:1', 'max:10', 'regex:/^[0-9a-zA-Z\-]*$/'],
            'postal_code' => ['required', 'string', function ($attribute, $value, $fail) {
                $allowedPostalCodes = ['5271TH', '5271TJ', '5271ZE', '5271ZH'];
                if (!in_array($value, $allowedPostalCodes)) {
                    $fail('Deze postcode komt niet uit de regio Maaskantje');
                }
            }],
            'city' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/'],
            'addition' => ['nullable', 'string', 'max:10', 'regex:/^[a-zA-Z0-9\-]*$/'],
        ], [
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

        $family = Family::findOrFail($id);
        $contactPerFamily = $family->contactPerFamilies()->first();
        
        // Update contact information
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

        // Update person information
        $representative = $family->people()->where('is_representative', true)->first();
        if ($representative) {
            $representative->update([
                'first_name' => $validatedData['first_name'],
                'infix' => $validatedData['infix'],
                'last_name' => $validatedData['last_name'],
                'date_of_birth' => $validatedData['date_of_birth'],
            ]);
        }

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
