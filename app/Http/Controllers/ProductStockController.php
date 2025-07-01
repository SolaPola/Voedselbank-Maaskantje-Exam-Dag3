<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProductStockController extends Controller
{
    /**
     * Display the product stock overview.
     */
    public function index(): View
    {
        Log::info('ProductStockController accessed by user: ' . auth()->user()->email);
        
        try {
            // Try stored procedure first
            $productStock = DB::select('CALL GetProductStockOverview()');
        } catch (\Exception $e) {
            Log::info('Stored procedure failed, using fallback query: ' . $e->getMessage());
            
            // Fallback to regular query if stored procedure doesn't exist
            $productStock = DB::table('products as p')
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
                ->where('ppw.isactive', 1)
                ->orderBy('p.name')
                ->orderBy('c.name')
                ->get();
        }
        
        Log::info('Found ' . count($productStock) . ' products in stock');
        
        return view('product-stock.index', compact('productStock'));
    }

    /**
     * Get product stock data as JSON for AJAX requests.
     */
    public function getData()
    {
        try {
            $productStock = DB::select('CALL GetProductStockOverview()');
        } catch (\Exception $e) {
            $productStock = DB::table('products as p')
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
                ->where('ppw.isactive', 1)
                ->orderBy('p.name')
                ->orderBy('c.name')
                ->get();
        }
        
        return response()->json($productStock);
    }
}
