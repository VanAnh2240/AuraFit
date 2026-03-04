<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<link rel="stylesheet" href="{{ asset('frontend/css/header.css') }}">

<header class="header container-fluid">
    <ul class="nav navbar container">

        {{-- Brand --}}
        <li>
            <a href="{{ route('home') }}" class="nav_brand hihi">
                <h1>AuraFit</h1>
            </a>
        </li>

        {{-- Search box (desktop) --}}
        <li class="col-5 d-md-inline d-none search_box">
            <form action="{{ route('shop.search') }}" method="POST">
                @csrf
                <input name="search" id="searchbox" placeholder="Tìm kiếm sản phẩm..." maxlength="100">
                <button type="submit" class="search-btn">
                    <i class="bx bx-search-alt"></i>
                </button>
            </form>
        </li>

        {{-- Icons --}}
        <li class="header_icons col-md-auto text-end gx-2">
            <div id="search-btn" class="p-1 d-md-none d-inline">
                <i class="bx bx-search-alt"></i>
            </div>
            <div id="cart-btn" class="p-1">
                <a href="{{ route('cart.index') }}">
                    <i class="bx bx-cart-alt"></i>
                </a>
            </div>
            <div id="user-btn" class="p-1">
                @if(Auth::check())
                    <div class="user-avatar-mini">
                        <img src="{{ !empty(Auth::user()->AVATAR)
                            ? Storage::url(Auth::user()->AVATAR)
                            : 'https://ps.w.org/user-avatar-reloaded/assets/icon-256x256.png?rev=2540745' }}"
                             alt="avatar">
                    </div>
                @else
                    <a href="{{ route('login') }}"><i class="bx bx-user-circle"></i></a>
                @endif
            </div>
        </li>

        {{-- Search mobile --}}
        <li class="search_box_hide" id="mobile-search">
            <form action="{{ route('shop.search') }}" method="POST">
                @csrf
                <input name="search" placeholder="Tìm kiếm..." maxlength="100">
                <button type="submit" class="search-btn">
                    <i class="bx bx-search-alt"></i>
                </button>
            </form>
        </li>

        {{-- Cart dropdown --}}
        @auth
        <li class="dropdown1" id="dropdown">

            @php
                $cartItems = DB::select(
                    'CALL get_cart_items_by_customer_id(?)', 
                    [Auth::user()->CUSTOMER_ID]
                );
            @endphp

            @forelse($cartItems as $product)
                <div class="cart-item">
                    <div class="cart_img">
                        <img src="{{ $product->IMAGE_LINK }}" alt="{{ $product->NAME }}">
                    </div>

                    <span class="product_title">
                        <a href="{{ route('product.detail', $product->PRODUCT_ID) }}">
                            {{ $product->NAME }}
                        </a>
                    </span>

                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:2px;flex-shrink:0;">
                        <span class="product_price">
                            {{ number_format($product->PRICE * $product->QUANTITY, 0, ',', '.') }}₫
                        </span>
                        <span style="font-size:11px;color:var(--clr-text-muted);">
                            x{{ $product->QUANTITY }}
                        </span>
                    </div>
                </div>

            @empty
                <div class="cart-empty" style="padding:15px;text-align:center;color:var(--clr-text-muted);">
                    Chưa có sản phẩm nào
                </div>
            @endforelse

            {{-- LUÔN hiển thị nút --}}
            <div class="summary">
                <a href="{{ route('cart.index') }}">
                    <button class="btn-order">Xem giỏ hàng</button>
                </a>
            </div>

        </li>
        @endauth

        {{-- Profile dropdown --}}
        @if(Auth::check())
        <li class="profile" id="profile">
            <a href="{{ route('account') }}">
                <img src="{{ !empty(Auth::user()->AVATAR)
                    ? Storage::url(Auth::user()->AVATAR)
                    : 'https://ps.w.org/user-avatar-reloaded/assets/icon-256x256.png?rev=2540745' }}"
                    alt="avatar">
            </a>
            <a class="name" href="{{ route('account') }}">{{ Auth::user()->USERNAME }}</a>
            @if(!empty(Auth::user()->FIRST_NAME))
                <span>{{ Auth::user()->LAST_NAME }} {{ Auth::user()->FIRST_NAME }}</span>
            @endif
            <a class="btn-order" href="{{ route('customer.orders') }}">Đơn đặt hàng</a>
            <a href="{{ route('logout') }}" class="btn-logout">Đăng xuất</a>
        </li>
        @endif

    </ul>
</header>

{{-- NAV BAR --}}
@php
    $navCategories   = DB::table('category')->orderBy('category_name', 'asc')->get();
    $navCategorySubs = DB::table('category_sub')->get()->groupBy('category_id');
@endphp

<nav class="nav-bar">
    <div class="nav-bar-inner">

        <div class="nav-item-wrap">
            <a href="{{ route('home') }}" class="nav-item-link">Trang chủ</a>
        </div>
        <div class="nav-divider"></div>

        <div class="nav-item-wrap">
            <a href="/shop" class="nav-item-link">Tất cả</a>
        </div>
        <div class="nav-divider"></div>

        @foreach ($navCategories as $cat)
            <div class="nav-item-wrap">
                <a href="/shop?category={{ $cat->category_id }}&sort=Newest" class="nav-item-link">
                    {{ $cat->category_name }}
                    @if(($navCategorySubs[$cat->category_id] ?? collect())->count())
                        <i class="bx bx-chevron-down"></i>
                    @endif
                </a>
                @if(($navCategorySubs[$cat->category_id] ?? collect())->count())
                    <div class="mega-drop">
                        <span class="mega-drop-header">{{ $cat->category_name }}</span>
                        @foreach ($navCategorySubs[$cat->category_id] as $sub)
                            <a href="/shop?category_sub={{ $sub->category_sub_id }}&sort=Newest"
                               class="mega-link">{{ $sub->category_sub_name }}</a>
                        @endforeach
                        <a href="/shop?category={{ $cat->category_id }}&sort=Newest"
                           class="mega-link mega-view-all">Xem tất cả →</a>
                    </div>
                @endif
            </div>
            @if(!$loop->last)<div class="nav-divider"></div>@endif
        @endforeach

        <div class="nav-divider"></div>
        <div class="nav-item-wrap">
            <a href="/chat" class="nav-item-link">
                <i class="bx bx-bulb"></i> Gợi ý phối đồ
            </a>
        </div>
        <div class="nav-divider"></div>
        <div class="nav-item-wrap">
            <a href="/tryon" class="nav-item-link">
                <i class="bx bx-camera"></i> Thử đồ ảo
            </a>
        </div>

    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cartBtn      = document.getElementById('cart-btn');
    const dropdown     = document.getElementById('dropdown');
    const userBtn      = document.getElementById('user-btn');
    const profile      = document.getElementById('profile');
    const searchBtn    = document.getElementById('search-btn');
    const mobileSearch = document.getElementById('mobile-search');
    const header       = document.querySelector('.header');

    function closeAll() {
        dropdown?.classList.remove('show');
        profile?.classList.remove('show');
        mobileSearch?.classList.remove('active');
    }

    searchBtn?.addEventListener('click', () => {
        mobileSearch?.classList.toggle('active');
        dropdown?.classList.remove('show');
        profile?.classList.remove('show');
    });

    if (cartBtn && dropdown) {
        let t;
        cartBtn.addEventListener('mouseenter', () => { clearTimeout(t); closeAll(); dropdown.classList.add('show'); });
        cartBtn.addEventListener('mouseleave', () => { t = setTimeout(() => dropdown.classList.remove('show'), 150); });
        dropdown.addEventListener('mouseenter', () => clearTimeout(t));
        dropdown.addEventListener('mouseleave', () => { t = setTimeout(() => dropdown.classList.remove('show'), 150); });
    }

    if (userBtn && profile) {
        let t;
        userBtn.addEventListener('mouseenter', () => { clearTimeout(t); closeAll(); profile.classList.add('show'); });
        userBtn.addEventListener('mouseleave', () => { t = setTimeout(() => profile.classList.remove('show'), 150); });
        profile.addEventListener('mouseenter', () => clearTimeout(t));
        profile.addEventListener('mouseleave', () => { t = setTimeout(() => profile.classList.remove('show'), 150); });
    }

    document.addEventListener('click', (e) => {
        if (cartBtn && dropdown && !cartBtn.contains(e.target) && !dropdown.contains(e.target))
            dropdown.classList.remove('show');
        if (userBtn && profile && !userBtn.contains(e.target) && !profile.contains(e.target))
            profile.classList.remove('show');
    });

    window.addEventListener('scroll', () => {
        header?.classList.toggle('scrolled', window.scrollY > 10);
    });
});
</script>