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
}
