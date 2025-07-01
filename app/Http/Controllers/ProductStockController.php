<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\Category;

class ProductStockController extends Controller
{
    /**
     * Display the product stock overview.
     */
    public function index(Request $request): View
    {
        Log::info('Voorraaroverzicht bezocht door gebruiker: ' . auth()->user()->email);
        
        $categoryFilter = $request->get('category_filter');
        
        try {
            // Try stored procedure first (modified to support filtering)
            if ($categoryFilter) {
                $productStock = DB::select('CALL GetProductStockOverviewByCategory(?)', [$categoryFilter]);
            } else {
                $productStock = DB::select('CALL GetProductStockOverview()');
            }
        } catch (\Exception $e) {
            Log::info('Opgeslagen procedure mislukt, gebruik fallback query: ' . $e->getMessage());
            
            // Fallback to regular query with optional category filter
            $query = DB::table('products as p')
                ->join('categories as c', 'p.category_id', '=', 'c.id')
                ->join('product_per_warehouses as ppw', 'p.id', '=', 'ppw.product_id')
                ->join('warehouses as w', 'ppw.warehouse_id', '=', 'w.id')
                ->select(
                    'p.id as product_id',
                    'p.name as product_name',
                    'c.name as category_name',
                    'w.packaging_unit',
                    'w.quantity',
                    'ppw.location',
                    'p.status',
                    'p.expiry_date'
                )
                ->where('p.isactive', 1)
                ->where('c.isactive', 1)
                ->where('w.isactive', 1)
                ->where('ppw.isactive', 1);

            if ($categoryFilter) {
                $query->where('c.id', $categoryFilter);
            }

            $productStock = $query->orderBy('p.name')
                ->orderBy('c.name')
                ->get();
        }
        
        // Get all categories for the filter dropdown
        $categories = Category::where('isactive', 1)->orderBy('name')->get();
        
        Log::info('Gevonden ' . count($productStock) . ' producten op voorraad');
        
        return view('product-stock.index', compact('productStock', 'categories'));
    }

    /**
     * Show detailed view of a specific product.
     */
    public function show($productId): View
    {
        try {
            $productData = DB::table('products as p')
                ->join('categories as c', 'p.category_id', '=', 'c.id')
                ->join('product_per_warehouses as ppw', 'p.id', '=', 'ppw.product_id')
                ->join('warehouses as w', 'ppw.warehouse_id', '=', 'w.id')
                ->select(
                    'p.id',
                    'p.name',
                    'p.barcode',
                    'p.status',
                    'p.allergy_type',
                    'p.description',
                    'p.expiry_date',
                    'c.name as category_name',
                    'w.packaging_unit',
                    'w.quantity',
                    'w.date_received',
                    'w.date_delivered',
                    'ppw.location'
                )
                ->where('p.id', $productId)
                ->where('p.isactive', 1)
                ->where('c.isactive', 1)
                ->where('w.isactive', 1)
                ->where('ppw.isactive', 1)
                ->first();

            if (!$productData) {
                abort(404, 'Product niet gevonden');
            }

            // Convert to objects for easier access in view
            $product = (object) [
                'id' => $productData->id,
                'name' => $productData->name,
                'barcode' => $productData->barcode,
                'status' => $productData->status,
                'allergy_type' => $productData->allergy_type,
                'description' => $productData->description,
                'expiry_date' => $productData->expiry_date,
                'category' => (object) ['name' => $productData->category_name]
            ];

            $productPerWarehouse = (object) [
                'location' => $productData->location
            ];

            $warehouse = (object) [
                'packaging_unit' => $productData->packaging_unit,
                'quantity' => $productData->quantity,
                'date_received' => $productData->date_received,
                'date_delivered' => $productData->date_delivered
            ];

            return view('product-stock.show', compact('product', 'productPerWarehouse', 'warehouse'));
        } catch (\Exception $e) {
            Log::error('Fout bij het tonen van product details: ' . $e->getMessage());
            abort(500, 'Er is een fout opgetreden bij het laden van de productdetails');
        }
    }

    /**
     * Get detailed information for a specific product.
     */
    public function getProductDetails($productId)
    {
        try {
            $productDetails = DB::table('products as p')
                ->join('categories as c', 'p.category_id', '=', 'c.id')
                ->join('product_per_warehouses as ppw', 'p.id', '=', 'ppw.product_id')
                ->join('warehouses as w', 'ppw.warehouse_id', '=', 'w.id')
                ->select(
                    'p.id as product_id',
                    'p.name',
                    'p.barcode',
                    'p.status',
                    'p.allergy_type',
                    'p.description',
                    'p.expiry_date',
                    'c.name as category_name',
                    'w.packaging_unit',
                    'w.quantity',
                    'w.date_received',
                    'ppw.location'
                )
                ->where('p.id', $productId)
                ->where('p.isactive', 1)
                ->where('c.isactive', 1)
                ->where('w.isactive', 1)
                ->where('ppw.isactive', 1)
                ->first();

            if (!$productDetails) {
                return response()->json(['error' => 'Product niet gevonden'], 404);
            }

            return response()->json($productDetails);
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van product details: ' . $e->getMessage());
            return response()->json(['error' => 'Er is een fout opgetreden'], 500);
        }
    }

    /**
     * Get product stock data as JSON for AJAX requests.
     */
    public function getData(Request $request)
    {
        $categoryFilter = $request->get('category_filter');
        
        try {
            if ($categoryFilter) {
                $productStock = DB::select('CALL GetProductStockOverviewByCategory(?)', [$categoryFilter]);
            } else {
                $productStock = DB::select('CALL GetProductStockOverview()');
            }
        } catch (\Exception $e) {
            $query = DB::table('products as p')
                ->join('categories as c', 'p.category_id', '=', 'c.id')
                ->join('product_per_warehouses as ppw', 'p.id', '=', 'ppw.product_id')
                ->join('warehouses as w', 'ppw.warehouse_id', '=', 'w.id')
                ->select(
                    'p.id as product_id',
                    'p.name as product_name',
                    'c.name as category_name',
                    'w.packaging_unit',
                    'w.quantity',
                    'ppw.location',
                    'p.status',
                    'p.expiry_date'
                )
                ->where('p.isactive', 1)
                ->where('c.isactive', 1)
                ->where('w.isactive', 1)
                ->where('ppw.isactive', 1);

            if ($categoryFilter) {
                $query->where('c.id', $categoryFilter);
            }

            $productStock = $query->orderBy('p.name')
                ->orderBy('c.name')
                ->get();
        }
        
        return response()->json($productStock);
    }

    /**
     * Show the form for editing a specific product.
     */
    public function edit($productId): View
    {
        try {
            $productData = DB::table('products as p')
                ->join('categories as c', 'p.category_id', '=', 'c.id')
                ->join('product_per_warehouses as ppw', 'p.id', '=', 'ppw.product_id')
                ->join('warehouses as w', 'ppw.warehouse_id', '=', 'w.id')
                ->select(
                    'p.id',
                    'p.name',
                    'p.barcode',
                    'p.status',
                    'p.allergy_type',
                    'p.description',
                    'p.expiry_date',
                    'c.name as category_name',
                    'w.packaging_unit',
                    'w.quantity',
                    'w.date_received',
                    'w.date_delivered',
                    'ppw.location',
                    'ppw.id as ppw_id',
                    'w.id as warehouse_id'
                )
                ->where('p.id', $productId)
                ->where('p.isactive', 1)
                ->where('c.isactive', 1)
                ->where('w.isactive', 1)
                ->where('ppw.isactive', 1)
                ->first();

            if (!$productData) {
                abort(404, 'Product niet gevonden');
            }

            // Convert to objects for easier access in view
            $product = (object) [
                'id' => $productData->id,
                'name' => $productData->name,
                'barcode' => $productData->barcode,
                'status' => $productData->status,
                'allergy_type' => $productData->allergy_type,
                'description' => $productData->description,
                'expiry_date' => $productData->expiry_date ? \Carbon\Carbon::parse($productData->expiry_date) : null,
                'category' => (object) ['name' => $productData->category_name]
            ];

            $productPerWarehouse = (object) [
                'id' => $productData->ppw_id,
                'location' => $productData->location
            ];

            $warehouse = (object) [
                'id' => $productData->warehouse_id,
                'packaging_unit' => $productData->packaging_unit,
                'quantity' => $productData->quantity,
                'date_received' => $productData->date_received ? \Carbon\Carbon::parse($productData->date_received) : null,
                'date_delivered' => $productData->date_delivered ? \Carbon\Carbon::parse($productData->date_delivered) : null
            ];

            return view('product-stock.edit', compact('product', 'productPerWarehouse', 'warehouse'));
        } catch (\Exception $e) {
            Log::error('Fout bij het bewerken van product: ' . $e->getMessage());
            abort(500, 'Er is een fout opgetreden bij het laden van de bewerkingspagina');
        }
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:13',
            'expiry_date' => 'nullable|date',
            'location' => 'required|string|max:255',
            'date_received' => 'nullable|date',
            'date_delivered' => 'nullable|date',
            'quantity' => 'required|integer|min:0',
            'delivered_quantity' => 'nullable|integer|min:0'
        ], [
            'name.required' => 'Het veld productnaam is verplicht.',
            'name.string' => 'Het veld productnaam moet een tekst zijn.',
            'name.max' => 'Het veld productnaam mag niet langer zijn dan :max karakters.',
            'barcode.string' => 'Het veld barcode moet een tekst zijn.',
            'barcode.max' => 'Het veld barcode mag niet langer zijn dan :max karakters.',
            'expiry_date.date' => 'Het veld houdbaarheidsdatum moet een geldige datum zijn.',
            'location.required' => 'Het veld magazijnlocatie is verplicht.',
            'location.string' => 'Het veld magazijnlocatie moet een tekst zijn.',
            'location.max' => 'Het veld magazijnlocatie mag niet langer zijn dan :max karakters.',
            'date_received.date' => 'Het veld ontvangstdatum moet een geldige datum zijn.',
            'date_delivered.date' => 'Het veld uitleveringsdatum moet een geldige datum zijn.',
            'quantity.required' => 'Het veld aantal op voorraad is verplicht.',
            'quantity.integer' => 'Het veld aantal op voorraad moet een geheel getal zijn.',
            'quantity.min' => 'Het veld aantal op voorraad moet minimaal :min zijn.',

            'delivered_quantity.integer' => 'Het veld aantal uitgeleverde producten moet een geheel getal zijn.',
            'delivered_quantity.min' => 'Het veld aantal uitgeleverde producten moet minimaal :min zijn.'
        ]);

        try {
            DB::beginTransaction();

            // Update product
            DB::table('products')
                ->where('id', $productId)
                ->update([
                    'name' => $request->name,
                    'barcode' => $request->barcode,
                    'expiry_date' => $request->expiry_date,
                    'updated_at' => now()
                ]);

            // Update product per warehouse location
            DB::table('product_per_warehouses')
                ->where('product_id', $productId)
                ->update([
                    'location' => $request->location,
                    'updated_at' => now()
                ]);

            // Get warehouse ID for this product
            $warehouseId = DB::table('product_per_warehouses')
                ->where('product_id', $productId)
                ->value('warehouse_id');

            // Calculate new quantity if delivery quantity is provided
            $newQuantity = $request->quantity;
            if ($request->delivered_quantity && $request->delivered_quantity > 0) {
                $newQuantity = max(0, $request->quantity - $request->delivered_quantity);
            }

            // Update warehouse
            DB::table('warehouses')
                ->where('id', $warehouseId)
                ->update([
                    'date_received' => $request->date_received,
                    'date_delivered' => $request->date_delivered,
                    'quantity' => $newQuantity,
                    'updated_at' => now()
                ]);

            DB::commit();

            return redirect()->route('product-stock.show', $productId)
                ->with('success', 'Product is succesvol bijgewerkt.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Fout bij het bijwerken van product: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Er is een fout opgetreden bij het bijwerken van het product.'])
                        ->withInput();
        }
    }
}
    
