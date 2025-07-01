<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        // Filter suppliers by type if requested
        $query = Supplier::with(['contacts']);
        if ($request->filled('type')) {
            $query->where('supplier_type', $request->input('type'));
        }
        $suppliers = $query->get();
        return view('supplier.index', compact('suppliers'));
    }

    public function products(Supplier $supplier)
    {
        // Haal alle producten op die bij deze supplier horen
        $products = Product::where('supplier_id', $supplier->id)->get();
        return view('supplier.products', compact('supplier', 'products'));
    }

    // Handles both GET (show form) and POST (update) for editing expiration date
    public function edit(Request $request, Product $product)
    {
        if ($request->isMethod('post')) {
            $oldDate = $product->expiration_date;
            $newDate = $request->input('expiration_date');
            if ($newDate && $newDate !== $oldDate) {
                $product->expiration_date = $newDate;
                $product->save();
                return redirect()
                    ->route('manager.suppliers.products', ['supplier' => $product->supplier_id])
                    ->with('success', 'De houdbaarheidsdatum is gewijzigd.');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'De houdbaarheidsdatum is niet gewijzigd.');
            }
        }
        return view('supplier.edit', compact('product'));
    }
}
