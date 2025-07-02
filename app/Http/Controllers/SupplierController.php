<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function show(Supplier $supplier)
    {
        // Haal alle producten op die bij deze supplier horen
        $products = Product::where('supplier_id', $supplier->id)->get();
        return view('supplier.show', compact('supplier', 'products'));
    }

    public function edit(Request $request, Product $product)
    {
        if ($request->isMethod('post')) {
            $oldDate = $product->expiry_date;
            $newDate = $request->input('expiry_date');

            if ($newDate && $newDate !== $oldDate) {
                $old = Carbon::parse($oldDate);
                $new = Carbon::parse($newDate);
                $diff = $old->diffInDays($new, false); // correct: old->diffInDays(new, false)

                // Show red feedback if 7 days or more in the future
                if ($diff < -7) {
                    return redirect()->back()->with('error', 'De houdbaarheidsdatum mag met maximaal 7 dagen worden verlengd');
                }

                // Green feedback for all other cases (including negative diff and 0-6 days forward)
                $product->expiry_date = $newDate;
                $product->save();
                return redirect()->back()->with('success', 'De houdbaarheidsdatum is gewijzigd.');
            } else {
                return redirect()->back()->with('error', 'De houdbaarheidsdatum is niet gewijzigd.');
            }
        }
        return view('supplier.edit', compact('product'));
    }
}
