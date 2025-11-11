<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseLog;
use App\Models\StockChange;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $u = auth()->user();
        if (!$u || $u->role !== 'superadmin') abort(403);

        // Top 5 más vendidos
        $topSold = PurchaseLog::select('product_id', DB::raw('SUM(qty) as sold'))
            ->groupBy('product_id')
            ->orderByDesc('sold')
            ->with('product:id,name')
            ->limit(5)
            ->get()
            ->map(fn($r) => ['label' => $r->product?->name ?? ('#'.$r->product_id), 'value' => (int)$r->sold]);

        // 5 menor stock
        $lowStock = Product::select('name','stock')
            ->orderBy('stock','asc')
            ->limit(5)
            ->get()
            ->map(fn($p) => ['label' => $p->name, 'value' => (int)$p->stock]);

        // Compras recientes
        $recentPurchases = PurchaseLog::with(['user:id,name','product:id,name'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get(['id','user_id','product_id','qty','price','total_price','created_at']);

        // Cambios de stock recientes
        $recentStockChanges = StockChange::with(['user:id,name','product:id,name'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get(['id','user_id','product_id','old_stock','new_stock','delta','reason','created_at']);

        return view('analytics.index', [
            'topSold' => $topSold,
            'lowStock' => $lowStock,
            'recentPurchases' => $recentPurchases,
            'recentStockChanges' => $recentStockChanges,
        ]);
    }
}