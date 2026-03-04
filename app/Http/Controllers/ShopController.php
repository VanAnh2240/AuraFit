<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    // ── Query chung có filter + sort ─────────────────────────────────
    private function buildQuery(Request $request)
    {
        $selectedSubs  = $request->input('category_sub', []);
        $selectedPrice = $request->input('price', '');
        $sortOption    = $request->input('sort', 'Newest');

        $query = product::with(['images', 'colors'])
            ->where('is_selling', 1);

        if (!empty($selectedSubs)) {
            $query->whereIn('category_sub_id', $selectedSubs);
        }

        if (!empty($selectedPrice) && str_contains($selectedPrice, '-')) {
            [$min, $max] = explode('-', $selectedPrice);
            $query->whereBetween('price', [(float)$min, (float)$max]);
        }

        match ($sortOption) {
            'Price (low to high)' => $query->orderBy('price', 'asc'),
            'Price (high to low)' => $query->orderBy('price', 'desc'),
            'Most popular'        => $query->orderBy('price', 'desc'),
            default               => $query->orderBy('product_id', 'desc'),
        };

        return $query;
    }

    // ── Trang chính ──────────────────────────────────────────────────
    public function index(Request $request)
    {
        $categories   = DB::table('category')->orderBy('category_name')->get();
        $categorySubs = DB::table('category_sub')->orderBy('category_sub_name')->get()
                          ->groupBy('category_id');

        $products      = $this->buildQuery($request)->paginate(12)->withQueryString();
        $selectedPrice = $request->input('price', '');
        $selectedSubs  = $request->input('category_sub', []);

        return view('shop.index', compact(
            'products', 'categories', 'categorySubs', 'selectedPrice', 'selectedSubs'
        ));
    }

    // ── AJAX filter — trả thêm total + pagination ────────────────────
    public function filter(Request $request)
    {
        $products = $this->buildQuery($request)->paginate(12)->withQueryString();

        return response()->json([
            'html'       => view('shop.shop', compact('products'))->render(),
            'total'      => $products->total(),
            'pagination' => $products->links()->toHtml(),
        ]);
    }

    // ── Tìm kiếm ─────────────────────────────────────────────────────
    public function search(Request $request)
    {
        $keyword = trim($request->input('search', ''));

        $products = product::with(['images', 'colors'])
            ->where('is_selling', 1)
            ->where('name', 'like', '%' . $keyword . '%')
            ->orderBy('product_id', 'desc')
            ->paginate(12)
            ->withQueryString();

        $categories   = DB::table('category')->orderBy('category_name')->get();
        $categorySubs = DB::table('category_sub')->orderBy('category_sub_name')->get()
                          ->groupBy('category_id');

        $selectedPrice = '';
        $selectedSubs  = [];

        return view('shop.index', compact(
            'products', 'categories', 'categorySubs', 'selectedPrice', 'selectedSubs'
        ))->with('keyword', $keyword);
    }
}