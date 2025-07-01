<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
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
        // Haal alle producten op die bij deze supplier horen
        $products = Product::where('supplier_id', $supplier->id)->get();
        return view('supplier.products', compact('supplier', 'products'));
    }

    // Use this method for the edit route
    public function edit(Product $product)
    {
        return view('supplier.edit', compact('product'));
    }
}
