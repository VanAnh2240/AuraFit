<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $categories = DB::table('category')
            ->orderBy('category_name', 'asc')
            ->get();

        $categorySubs = DB::table('category_sub')
            ->orderBy('category_sub_id', 'asc')
            ->get()
            ->groupBy('category_id');

        $allCategorySubs = DB::table('category_sub')
            ->orderBy('category_sub_id', 'asc')
            ->get();

        // ── Lấy sản phẩm theo từng category_sub ─────────────
        $products = [];
        $allProductIds = [];

        foreach ($allCategorySubs as $sub) {
            $items = DB::table('product')
                ->leftJoin('product_image', 'product_image.product_id', '=', 'product.product_id')
                ->where('product.category_sub_id', $sub->category_sub_id)
                ->where('product.is_selling', 1)
                ->groupBy('product.product_id', 'product.name', 'product.price')
                ->select(
                    'product.product_id',
                    'product.name',
                    'product.price',
                    DB::raw('MIN(product_image.image_link) AS image_link')
                )
                ->limit(8)
                ->get();

            $products[$sub->category_sub_id] = $items;

            // Gom tất cả product_id để query màu 1 lần
            foreach ($items as $item) {
                $allProductIds[] = $item->product_id;
            }
        }

        // ── Query màu 1 lần cho toàn bộ sản phẩm ────────────
        $allProductIds = array_unique($allProductIds);

        $colorsByProduct = DB::table('product_color')
            ->join('color', 'color.color_code', '=', 'product_color.color_code')
            ->whereIn('product_color.product_id', $allProductIds)
            ->select(
                'product_color.product_id',
                'color.type_en',
                'color.color_name_vi'
            )
            ->distinct()
            ->get()
            ->groupBy('product_id');  // key: product_id → collection of colors

        // ── Gắn màu vào từng sản phẩm ────────────────────────
        foreach ($products as $subId => $items) {
            foreach ($items as $item) {
                $item->colors = $colorsByProduct->get($item->product_id, collect());
            }
        }

        // ── HOT SALE ──────────────────────────────────────────
        $productsHotSale = DB::table('product')
            ->leftJoin('product_image', 'product_image.product_id', '=', 'product.product_id')
            ->joinSub(
                DB::table('order_item')
                    ->select('PRODUCT_ID', DB::raw('SUM(QUANTITY) as total_qty'))
                    ->groupBy('PRODUCT_ID')
                    ->orderByDesc('total_qty')
                    ->limit(4),
                'top_products',
                fn ($join) => $join->on(
                    DB::raw('CAST(product.product_id AS CHAR)'), '=',
                    DB::raw('CAST(top_products.PRODUCT_ID AS CHAR)')
                )
            )
            ->where('product.is_selling', 1)
            ->groupBy('product.product_id', 'product.name', 'product.price')
            ->select(
                'product.product_id',
                'product.name',
                'product.price',
                DB::raw('MIN(product_image.image_link) AS image_link')
            )
            ->get();

        // ── LATEST ────────────────────────────────────────────
        $productsLatest = DB::table('product')
            ->leftJoin('product_image', 'product_image.product_id', '=', 'product.product_id')
            ->where('product.is_selling', 1)
            ->groupBy('product.product_id', 'product.name', 'product.price')
            ->orderByDesc('product.product_id')
            ->select(
                'product.product_id',
                'product.name',
                'product.price',
                DB::raw('MIN(product_image.image_link) AS image_link')
            )
            ->limit(4)
            ->get();

        return view('home', compact(
            'categories', 'categorySubs', 'allCategorySubs',
            'products', 'productsHotSale', 'productsLatest'
        ));
    }
}