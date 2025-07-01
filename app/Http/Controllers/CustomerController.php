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
        $request->validate([
            'email' => 'required|email',
            'mobile' => 'required|string',
            'street' => 'required|string',
            'house_number' => 'required|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
        ]);

        $family = Family::findOrFail($id);
        $contactPerFamily = $family->contactPerFamilies()->first();
        
        if ($contactPerFamily && $contactPerFamily->contact) {
            $contactPerFamily->contact->update([
                'email' => $request->email,
                'mobile' => $request->mobile,
                'street' => $request->street,
                'house_number' => $request->house_number,
                'addition' => $request->addition,
                'postal_code' => $request->postal_code,
                'city' => $request->city,
            ]);
        }

        return redirect()->route('customers.index')->with('success', 'Contactgegevens bijgewerkt');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
