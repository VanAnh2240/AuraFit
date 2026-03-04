<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Profile;
use App\Models\Order;
use App\Models\Province;
use App\Models\Ward;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    const FAVORITE_STYLES = [
        'Minimalist', 'Classic', 'Streetwear', 'Bohemian',
        'Sporty', 'Casual', 'Elegant', 'Vintage', 'Preppy', 'Edgy',
    ];

    // ----------------------------------------------------------------
    // TRANG: Tài khoản của tôi
    // ----------------------------------------------------------------

    public function account()
    {
        $user      = Auth::user();
        $provinces = Province::orderBy('name')->get();

        // Load wards theo province hiện tại của user (nếu có)
        $wards = $user->province_code
            ? Ward::where('province_code', $user->province_code)->orderBy('name')->get()
            : collect();

        return view('pages.account', compact('user', 'provinces', 'wards'));
    }

    public function updateAccount(Request $req, $id)
    {
        $req->validate([
            'fullName'       => 'nullable|string|max:100',
            'avatar'         => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'province_code'  => 'nullable|exists:provinces,code',
            'ward_code'      => 'nullable|exists:wards,code',
            'address_detail' => 'nullable|string|max:255',
            'birthday'       => 'nullable|date|before:today',
        ]);

        $user = Customer::findOrFail($id);

        // Tên
        if ($req->filled('fullName')) {
            $parts = explode(' ', trim($req->fullName), 2);
            $user->LAST_NAME  = $parts[0] ?? null;
            $user->FIRST_NAME = $parts[1] ?? null;
        }

        // Email / Phone (gửi từ modal)
        if ($req->filled('email')) {
            $req->validate(['email' => 'email|unique:customer,EMAIL,' . $id . ',CUSTOMER_ID']);
            $user->EMAIL = $req->email;
        }
        if ($req->filled('phone')) {
            $req->validate(['phone' => 'digits_between:9,11']);
            $user->PHONE_NUMBER = $req->phone;
        }

        // Birthday
        if ($req->filled('birthday')) {
            $user->birthday = $req->birthday;
        }

        // Địa chỉ (2 cấp: province → ward)
        $user->province_code  = $req->province_code  ?: null;
        $user->ward_code      = $req->ward_code      ?: null;
        $user->address_detail = $req->address_detail ?: null;

        // Avatar
        if ($req->hasFile('avatar')) {
            if ($user->AVATAR) Storage::disk('public')->delete($user->AVATAR);
            $user->AVATAR = $req->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->back()->with('success', 'Cập nhật tài khoản thành công!');
    }

    // ----------------------------------------------------------------
    // TRANG: Thông tin cá nhân
    // ----------------------------------------------------------------

    public function personalProfile()
    {
        $user           = Auth::user();
        $profile        = Profile::firstOrNew(['customer_id' => $user->CUSTOMER_ID]);
        $favoriteStyles = self::FAVORITE_STYLES;

        return view('pages.profile', compact('user', 'profile', 'favoriteStyles'));
    }

    public function updatePersonalProfile(Request $req, $id)
    {
        $req->validate([
            'weight'         => 'nullable|numeric|min:20|max:300',
            'height'         => 'nullable|numeric|min:50|max:250',
            'body_shape'     => 'nullable|in:APPLE,PEAR,HOURGLASS,RECTANGLE,INVERTED_TRIANGLE',
            'undertone'      => 'nullable|in:WARM,COOL,NEUTRAL',
            'personal_color' => 'nullable|in:SPRING_WARM,SUMMER_COOL,AUTUMN_WARM,WINTER_COOL',
            'favorite_styles'=> 'nullable|array',
            'portrait_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $profile = Profile::firstOrNew(['customer_id' => $id]);

        $profile->weight         = $req->weight         ?: null;
        $profile->height         = $req->height         ?: null;
        $profile->body_shape     = $req->body_shape     ?: null;
        $profile->undertone      = $req->undertone      ?: null;
        $profile->personal_color = $req->personal_color ?: null;
        $profile->favorite_styles = $req->has('favorite_styles')
            ? json_encode($req->favorite_styles)
            : null;

        // Portrait
        if ($req->hasFile('portrait_image')) {
            if ($profile->portrait_image) {
                Storage::disk('public')->delete($profile->portrait_image);
            }
            $profile->portrait_image = $req->file('portrait_image')->store('portraits', 'public');
        }

        $profile->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin cá nhân thành công!');
    }

    // ----------------------------------------------------------------
    // TRANG: Đổi mật khẩu
    // ----------------------------------------------------------------

    public function updatePass(Request $req, $id)
    {
        $req->validate([
            'old_pass'    => 'required',
            'new_pass'    => 'required|min:6',
            'cf_new_pass' => 'required|same:new_pass',
        ]);

        $user = Customer::findOrFail($id);

        if ($req->old_pass !== $user->PASSWORD) {
            return redirect()->back()->with('error', 'Mật khẩu cũ không chính xác');
        }

        $user->PASSWORD = $req->new_pass;
        $user->save();

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // ----------------------------------------------------------------
    // TRANG: Quản lý đơn hàng
    // ----------------------------------------------------------------

    public function listorder(Request $request)
    {
        $user = Auth::user();

        // Whitelist sort columns (tránh SQL injection)
        $allowedSorts = ['ORDER_ID', 'ORDER_DATE', 'TOTAL_PRICE', 'PAYMENT_STATUS'];
        $sort = in_array($request->sort, $allowedSorts) ? $request->sort : 'ORDER_DATE';
        $dir  = $request->dir === 'asc' ? 'asc' : 'desc';

        $list_order = Order::where('CUSTOMER_ID', $user->CUSTOMER_ID)
            ->when($request->search, fn($q) => $q->where('ADDRESS', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('PAYMENT_STATUS', $request->status))
            ->orderBy($sort, $dir)
            ->get();

        return view('pages.myorder', compact('user', 'list_order'));
    }

    // ----------------------------------------------------------------
    // API: Cascade địa chỉ Province → Ward (2 cấp, không có district)
    // ----------------------------------------------------------------

    public function getWards(Request $req)
    {
        $wards = Ward::where('province_code', $req->province_code)
            ->orderBy('name')
            ->get(['code', 'name', 'full_name']);

        return response()->json($wards);
    }
}