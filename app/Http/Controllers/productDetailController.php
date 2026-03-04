<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class productDetailController extends Controller
{
    public function productDetail($product_id)
    {
        // ── Thông tin sản phẩm ──────────────────────────────
        $product = DB::table('product')
            ->where('product.product_id', $product_id)
            ->where('product.is_selling', 1)
            ->first();

        abort_if(!$product, 404);

        // ── Ảnh sản phẩm (kèm color_code để map với màu) ───
        $images = DB::table('product_image')
            ->where('product_id', $product_id)
            ->select('image_link', 'color_code')
            ->get();

        $mainImage = $images->first()?->image_link;

        // ── Màu sắc ──────────────────────────────────────────
        $colors = DB::table('product_color')
            ->join('color', 'color.color_code', '=', 'product_color.color_code')
            ->where('product_color.product_id', $product_id)
            ->select(
                'color.color_code',
                'color.type_en',
                'color.color_name_vi',
                'color.color_name_en'
            )
            ->get();

        // ── Category sub (để lấy tên danh mục) ──────────────
        $categorySub = DB::table('category_sub')
            ->join('category', 'category.category_id', '=', 'category_sub.category_id')
            ->where('category_sub.category_sub_id', $product->category_sub_id)
            ->select('category_sub.category_sub_name', 'category.category_name')
            ->first();

        // ── Sản phẩm tương tự (cùng category_sub) ───────────
        $similarProducts = DB::table('product')
            ->leftJoin('product_image', 'product_image.product_id', '=', 'product.product_id')
            ->where('product.category_sub_id', $product->category_sub_id)
            ->where('product.product_id', '!=', $product_id)
            ->where('product.is_selling', 1)
            ->groupBy('product.product_id', 'product.name', 'product.price')
            ->select(
                'product.product_id',
                'product.name',
                'product.price',
                DB::raw('MIN(product_image.image_link) AS image_link')
            )
            ->limit(5)
            ->get();

        // Gắn màu cho similar products
        $simIds = $similarProducts->pluck('product_id')->toArray();
        if (!empty($simIds)) {
            $simColors = DB::table('product_color')
                ->join('color', 'color.color_code', '=', 'product_color.color_code')
                ->whereIn('product_color.product_id', $simIds)
                ->select('product_color.product_id', 'color.type_en', 'color.color_name_vi')
                ->distinct()
                ->get()
                ->groupBy('product_id');

            foreach ($similarProducts as $sim) {
                $sim->colors = $simColors->get($sim->product_id, collect());
            }
        }

        // ── Thêm giỏ hàng ────────────────────────────────────
        $customer = Auth::check()
            ? DB::table('customer')->where('customer_id', Auth::id())->first()
            : null;

        return view('pages.productDetail', compact(
            'product', 'images', 'mainImage',
            'colors', 'categorySub',
            'similarProducts', 'customer'
        ));
    }

    public function addproduct(Request $request)
    {
        DB::statement('CALL add_product_to_cart_by_cart_id(?,?,?)', [
            Auth::user()->CART_ID,
            $request->product_id,
            $request->count ?? 1
        ]);
        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }
}