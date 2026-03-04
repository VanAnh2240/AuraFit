<?php

namespace App\Http\Controllers\cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private function cartId(): int
    {
        return (int) Auth::user()->CART_ID;
    }

    public function showCart()
    {
        $customerId = Auth::user()->CUSTOMER_ID;
        $cart = DB::select('CALL get_cart_items_by_customer_id(?)', [$customerId]);
        return view('pages.cart', compact('cart'));
    }

    /**
     * Xoá một sản phẩm khỏi giỏ hàng.
     * DELETE /cart/{productId}
     */
    public function removeFromCart(int $productId)
    {
        $deleted = DB::table('cart_has')
            ->where('product_id', $productId)
            ->where('CART_ID',    $this->cartId())
            ->delete();

        if (! $deleted) {
            return response()->json(['error' => 'Item not found in cart'], 404);
        }

        return response()->json(['success' => 'Item removed from cart']);
    }

    /**
     * Cập nhật số lượng một sản phẩm trong giỏ.
     * POST /cart/{productId}
     */
    public function updateCartItem(Request $request, int $productId)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);

        $cartItem = DB::table('cart_has')
            ->where('CART_ID',    $this->cartId())
            ->where('product_id', $productId)
            ->first();

        if (! $cartItem) {
            return response()->json(['error' => 'Item not found in cart'], 404);
        }

        $quantity = (int) $request->quantity;

        if ($quantity <= 0) {
            DB::table('cart_has')
                ->where('CART_ID',    $cartItem->CART_ID)
                ->where('product_id', $cartItem->product_id)
                ->delete();
        } else {
            DB::table('cart_has')
                ->where('CART_ID',    $cartItem->CART_ID)
                ->where('product_id', $cartItem->product_id)
                ->update(['QUANTITY' => $quantity]);
        }

        return response()->json(['success' => 'Cart updated']);
    }
}