<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\Category;

class ProductStockController extends Controller
{
    public function index(Request $request): View
    {
        Log::info('Voorraaroverzicht bezocht door gebruiker: ' . auth()->user()->email);

        $categoryFilter = $request->get('category_filter');

        try {
            if ($categoryFilter) {
                $productStock = DB::select('CALL GetProductStockOverviewByCategory(?)', [$categoryFilter]);
            } else {
                $productStock = DB::select('CALL GetProductStockOverview()');
            }
        } catch (\Exception $e) {
            Log::info('Opgeslagen procedure mislukt, gebruik fallback query: ' . $e->getMessage());

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

        $categories = Category::where('isactive', 1)->orderBy('name')->get();

        Log::info('Gevonden ' . count($productStock) . ' producten op voorraad');

        return view('product-stock.index', compact('productStock', 'categories'));
    }

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
                    'w.delivered_quantity',
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
                'delivered_quantity' => $productData->delivered_quantity ?? 0,
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
        // Get current warehouse stock from database first for validation
        $currentWarehouseData = DB::table('product_per_warehouses as ppw')
            ->join('warehouses as w', 'ppw.warehouse_id', '=', 'w.id')
            ->where('ppw.product_id', $productId)
            ->where('ppw.isactive', 1)
            ->where('w.isactive', 1)
            ->select('w.quantity', 'w.delivered_quantity')
            ->first();

        if (!$currentWarehouseData) {
            return back()->withErrors(['error' => 'Product niet gevonden in magazijn.'])->withInput();
        }

        $currentStock = $currentWarehouseData->quantity;

        $request->validate([
            'location' => 'required|string|max:255',
            'date_delivered' => 'nullable|date',
            'delivered_quantity' => 'nullable|integer|min:0|max:' . $currentStock
        ], [
            'location.required' => 'Het veld magazijnlocatie is verplicht.',
            'location.string' => 'Het veld magazijnlocatie moet een tekst zijn.',
            'location.max' => 'Het veld magazijnlocatie mag niet langer zijn dan :max karakters.',
            'date_delivered.date' => 'Het veld uitleveringsdatum moet een geldige datum zijn.',
            'delivered_quantity.integer' => 'Het veld aantal uitgeleverde producten moet een geheel getal zijn.',
            'delivered_quantity.min' => 'Het veld aantal uitgeleverde producten moet minimaal :min zijn.',
            'delivered_quantity.max' => 'De productgegevens kunnen niet worden gewijzigd.'
        ]);

        try {
            DB::beginTransaction();

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

            $deliveredQuantity = $request->delivered_quantity ?? 0;

            // Calculate new warehouse quantity: current stock - delivered quantity
            $newWarehouseQuantity = $currentStock - $deliveredQuantity;

            // Update warehouse with new quantity and delivered quantity
            DB::table('warehouses')
                ->where('id', $warehouseId)
                ->update([
                    'date_delivered' => $request->date_delivered,
                    'quantity' => $newWarehouseQuantity, // Update the actual warehouse stock
                    'delivered_quantity' => $deliveredQuantity,
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
