<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        // Eager load contacts via the pivot table contact_per_suppliers
        $suppliers = Supplier::with(['contacts'])->get();
        return view('supplier.index', compact('suppliers'));
    }

    public function products(Supplier $supplier)
    {
        // Placeholder for product details per supplier
        return view('supplier.products', compact('supplier'));
    }
}
