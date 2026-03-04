@extends('layout.user_MainStructure')

@section('title', 'Giỏ hàng của tôi')

@section('content')

<style>
    .cart-page {
        background: linear-gradient(135deg, #fdf6f0 0%, #fce9f1 50%, #f0e8f8 100%);
        min-height: 100vh;
        padding: 3rem 0 5rem;
    }

    .cart-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .cart-header .breadcrumb-nav {
        font-size: .85rem;
        color: #b49ab0;
        margin-bottom: .75rem;
        letter-spacing: .05em;
    }

    .cart-header .breadcrumb-nav a {
        color: #b49ab0;
        text-decoration: none;
    }

    .cart-header .breadcrumb-nav a:hover { color: var(--main-color); }

    .cart-header h1 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.8rem;
        font-weight: 700;
        color: var(--main-color-dark, #39245F);
        letter-spacing: -.02em;
        margin-bottom: .5rem;
    }

    .cart-header .item-count {
        color: #b49ab0;
        font-size: .95rem;
        font-weight: 500;
    }

    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 2rem;
        align-items: start;
    }

    @media (max-width: 991px) {
        .cart-layout { grid-template-columns: 1fr; }
    }

    .cart-table-wrap {
        background: #fff;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 4px 30px rgba(120, 60, 130, .08);
    }

    .cart-table-head {
        display: grid;
        grid-template-columns: 100px 1fr 140px 130px 80px;
        padding: 1rem 1.5rem;
        background: linear-gradient(90deg, #f8f0fc, #fce4f0);
        font-size: .8rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--main-color-dark, #39245F);
        border-bottom: 1px solid #f0e0f0;
    }

    .cart-table-head div,
    .cart-row > div {
        display: flex;
        align-items: center;
    }

    .cart-table-head div:not(:first-child),
    .cart-row > div:not(:first-child) {
        justify-content: center;
    }

    .cart-row {
        display: grid;
        grid-template-columns: 100px 1fr 140px 130px 80px;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #faf0fa;
        transition: background .2s;
        animation: rowSlideIn .35s ease both;
    }

    .cart-row:last-child { border-bottom: none; }
    .cart-row:hover { background: #fdfaff; }

    @keyframes rowSlideIn {
        from { opacity: 0; transform: translateX(-12px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .cart-img-wrap {
        width: 76px;
        height: 90px;
        border-radius: .75rem;
        overflow: hidden;
        flex-shrink: 0;
        background: #f8f0fc;
    }

    .cart-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }

    .cart-row:hover .cart-img-wrap img { transform: scale(1.07); }

    .cart-product-info {
        padding-left: 1rem;
        flex-direction: column;
        align-items: flex-start !important;
        justify-content: center !important;
    }

    .cart-product-name {
        font-weight: 700;
        color: var(--main-color-dark, #39245F);
        font-size: .98rem;
        margin-bottom: .3rem;
        line-height: 1.3;
        text-transform: capitalize;
    }

    .cart-product-desc {
        font-size: .78rem;
        color: #b49ab0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .cart-price {
        font-weight: 700;
        color: var(--main-color, #8b2f7a);
        font-size: 1rem;
    }

    .qty-control {
        display: flex;
        align-items: center;
        background: #f8f0fc;
        border-radius: 2rem;
        padding: .2rem .4rem;
        gap: .1rem;
    }

    .qty-btn {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--main-color, #8b2f7a);
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s, color .2s;
        line-height: 1;
    }

    .qty-btn:hover {
        background: var(--main-color, #8b2f7a);
        color: white;
    }

    .qty-input {
        width: 36px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 700;
        font-size: .95rem;
        color: var(--main-color-dark, #39245F);
        outline: none;
        pointer-events: none;
    }

    .btn-delete {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1.5px solid #f0d0ea;
        background: transparent;
        color: #c084b0;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .2s;
    }

    .btn-delete:hover {
        background: #ff6b8a;
        border-color: #ff6b8a;
        color: white;
        transform: scale(1.1);
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-cart .empty-icon {
        font-size: 4rem;
        color: #e0c0e0;
        margin-bottom: 1rem;
    }

    .empty-cart p {
        color: #b49ab0;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .btn-shop {
        display: inline-block;
        padding: .75rem 2rem;
        background: var(--main-color, #8b2f7a);
        color: white;
        border-radius: 2rem;
        font-weight: 600;
        text-decoration: none;
        transition: all .2s;
    }

    .btn-shop:hover {
        background: var(--main-color-light, #cc94d5);
        color: white;
        transform: translateY(-2px);
    }

    .order-summary {
        background: #fff;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 4px 30px rgba(120, 60, 130, .08);
        position: sticky;
        top: 100px;
    }

    .order-summary-header {
        background: linear-gradient(135deg, var(--main-color-dark, #39245F), var(--main-color, #8b2f7a));
        padding: 1.5rem;
        color: white;
    }

    .order-summary-header h3 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
    }

    .order-summary-body { padding: 1.5rem; }

    .summary-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: .92rem;
        color: #7a6a7a;
    }

    .summary-line.total {
        border-top: 1.5px dashed #f0d0ea;
        padding-top: 1rem;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--main-color-dark, #39245F);
    }

    .summary-line .amount { font-weight: 600; color: var(--main-color-dark, #39245F); }
    .summary-line.total .amount { color: var(--main-color, #8b2f7a); font-size: 1.3rem; }

    .promo-wrap { margin-bottom: 1.25rem; }

    .promo-input-group {
        display: flex;
        gap: .5rem;
    }

    .promo-input {
        flex: 1;
        padding: .6rem 1rem;
        border: 1.5px solid #f0d0ea;
        border-radius: 2rem;
        font-size: .85rem;
        outline: none;
        transition: border-color .2s;
        color: var(--main-color-dark, #39245F);
    }

    .promo-input:focus { border-color: var(--main-color, #8b2f7a); }
    .promo-input::placeholder { color: #d0b0cc; }

    .btn-promo {
        padding: .6rem 1.1rem;
        border: none;
        border-radius: 2rem;
        background: var(--main-color, #8b2f7a);
        color: white;
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background .2s;
    }

    .btn-promo:hover { background: var(--main-color-light, #cc94d5); }

    .btn-checkout {
        display: block;
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--main-color-dark, #39245F), var(--main-color, #8b2f7a));
        color: white;
        border: none;
        border-radius: 2rem;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .05em;
        cursor: pointer;
        transition: all .25s;
        text-align: center;
        text-decoration: none;
        margin-top: .5rem;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 47, 122, .35);
        color: white;
    }

    .security-badges {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 1rem;
        color: #b49ab0;
        font-size: .75rem;
    }

    .security-badges span { display: flex; align-items: center; gap: .3rem; }

    .qty-badge {
        display: inline-block;
        background: var(--main-color, #8b2f7a);
        color: white;
        font-size: .7rem;
        font-weight: 700;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        line-height: 20px;
        text-align: center;
        margin-left: .4rem;
        vertical-align: middle;
    }
</style>

<div class="cart-page">
    <div class="container">

        {{-- Tiêu đề trang --}}
        <div class="cart-header">
            <div class="breadcrumb-nav">
                <a href="{{ route('home') }}">Trang chủ</a> &nbsp;/&nbsp; Giỏ hàng
            </div>
            <h1>Giỏ hàng của bạn <span class="qty-badge" id="cart-count">{{ count($cart) }}</span></h1>
            <p class="item-count">{{ count($cart) }} sản phẩm trong giỏ</p>
        </div>

        @if(count($cart) > 0)
        <div class="cart-layout">

            {{-- Danh sách sản phẩm --}}
            <div>
                <div class="cart-table-wrap">
                    <div class="cart-table-head">
                        <div>Ảnh</div>
                        <div style="justify-content:flex-start; padding-left:1rem;">Sản phẩm</div>
                        <div>Đơn giá</div>
                        <div>Số lượng</div>
                        <div>Xoá</div>
                    </div>

                    <div id="cart-items-container">
                        @foreach($cart as $item)
                        <div class="cart-row"
                             id="row-{{ $item->PRODUCT_ID }}"
                             data-price="{{ $item->PRICE }}"
                             data-qty="{{ $item->QUANTITY }}">

                            {{-- Ảnh --}}
                            <div>
                                <div class="cart-img-wrap">
                                    <img src="{{ $item->IMAGE_LINK }}" alt="{{ $item->NAME }}">
                                </div>
                            </div>

                            {{-- Tên & mô tả --}}
                            <div class="cart-product-info">
                                <div class="cart-product-name">{{ $item->NAME }}</div>
                                @if(!empty($item->DESCRIPTION))
                                    <div class="cart-product-desc">{{ $item->DESCRIPTION }}</div>
                                @endif
                            </div>

                            {{-- Đơn giá --}}
                            <div>
                                <span class="cart-price giaban">
                                    {{ number_format($item->PRICE, 0, '.', '.') }}₫
                                </span>
                            </div>

                            {{-- Số lượng --}}
                            <div>
                                <div class="qty-control">
                                    <button class="qty-btn btn-minus"
                                        data-url-update="{{ route('cart.update', $item->PRODUCT_ID) }}"
                                        data-url-del="{{ route('cart.remove', $item->PRODUCT_ID) }}">−</button>
                                    <input type="text" class="qty-input" value="{{ $item->QUANTITY }}" readonly>
                                    <button class="qty-btn btn-plus"
                                        data-url-update="{{ route('cart.update', $item->PRODUCT_ID) }}">+</button>
                                </div>
                            </div>

                            {{-- Xoá --}}
                            <div>
                                <button class="btn-delete btn-delete-item"
                                    data-url-del="{{ route('cart.remove', $item->PRODUCT_ID) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tiếp tục mua sắm --}}
                <div class="mt-3">
                    <a href="{{ route('shop.index') }}"
                       style="background:transparent; color:var(--main-color,#8b2f7a);
                              border:1.5px solid var(--main-color,#8b2f7a);
                              padding:.6rem 1.5rem; border-radius:2rem;
                              font-weight:600; font-size:.9rem;
                              text-decoration:none; display:inline-block; transition:all .2s;">
                        <i class='bx bx-arrow-back me-1'></i> Tiếp tục mua sắm
                    </a>
                </div>
            </div>

            {{-- Tóm tắt đơn hàng --}}
            <div>
                <div class="order-summary">
                    <div class="order-summary-header">
                        <h3>Tóm tắt đơn hàng</h3>
                    </div>
                    <div class="order-summary-body">

                        <div class="summary-line">
                            <span>Tạm tính</span>
                            <span class="amount" id="subtotal-display">—</span>
                        </div>
                        <div class="summary-line">
                            <span>Phí vận chuyển</span>
                            <span class="amount" style="color:#4caf50; font-weight:700;">Miễn phí</span>
                        </div>
                        <div class="summary-line total">
                            <span>Tổng cộng</span>
                            <span class="amount" id="total-price">—</span>
                        </div>


                        <button class="btn-checkout" onclick="placeOrder()">
                            <i class='bx bx-credit-card me-1'></i> Đặt hàng
                        </button>

                        <div class="security-badges">
                            <span><i class='bx bx-lock-alt'></i> Bảo mật</span>
                            <span><i class='bx bx-package'></i> Đổi trả dễ</span>
                            <span><i class='bx bx-badge-check'></i> Chính hãng</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @else
        {{-- Giỏ hàng trống --}}
        <div class="cart-table-wrap">
            <div class="empty-cart">
                <div class="empty-icon"><i class='bx bx-shopping-bag'></i></div>
                <p>Giỏ hàng của bạn đang trống. Hãy thêm sản phẩm yêu thích!</p>
                <a href="{{ route('shop.index') }}" class="btn-shop">Mua sắm ngay</a>
            </div>
        </div>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const CSRF = "{{ csrf_token() }}";

    function calcTotal() {
        let total = 0;
        document.querySelectorAll('.cart-row').forEach(row => {
            total += (parseFloat(row.dataset.price) || 0) * (parseInt(row.dataset.qty) || 0);
        });
        return total;
    }

    function refreshTotals() {
        const total = calcTotal();
        const fmt = n => n.toLocaleString('vi-VN') + '₫';
        document.getElementById('subtotal-display').textContent = fmt(total);
        document.getElementById('total-price').textContent      = fmt(total);

        const count = document.querySelectorAll('.cart-row').length;
        const badge = document.getElementById('cart-count');
        if (badge) badge.textContent = count;
    }

    refreshTotals();

    function ajaxPost(url, body) {
        return fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify(body)
        });
    }

    function ajaxDelete(url) {
        return fetch(url, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ _token: CSRF })
        });
    }

    function removeRow(row) {
        row.style.transition = 'opacity .35s, transform .35s, max-height .4s .1s, padding .4s .1s';
        row.style.overflow   = 'hidden';
        row.style.maxHeight  = row.offsetHeight + 'px';
        requestAnimationFrame(() => {
            row.style.opacity      = '0';
            row.style.transform    = 'translateX(30px)';
            row.style.maxHeight    = '0';
            row.style.padding      = '0';
            row.style.borderBottom = 'none';
        });
        setTimeout(() => { row.remove(); refreshTotals(); }, 450);
    }

    // Tăng số lượng
    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', () => {
            const row = btn.closest('.cart-row');
            const qty = parseInt(row.dataset.qty) + 1;
            row.dataset.qty = qty;
            row.querySelector('.qty-input').value = qty;
            refreshTotals();
            ajaxPost(btn.dataset.urlUpdate, { quantity: qty });
        });
    });

    // Giảm số lượng
    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', () => {
            const row = btn.closest('.cart-row');
            const qty = parseInt(row.dataset.qty) - 1;
            if (qty > 0) {
                row.dataset.qty = qty;
                row.querySelector('.qty-input').value = qty;
                refreshTotals();
                ajaxPost(btn.dataset.urlUpdate, { quantity: qty });
            } else {
                ajaxDelete(btn.dataset.urlDel).then(() => removeRow(row));
            }
        });
    });

    // Xoá sản phẩm
    document.querySelectorAll('.btn-delete-item').forEach(btn => {
        btn.addEventListener('click', () => {
            ajaxDelete(btn.dataset.urlDel).then(() => removeRow(btn.closest('.cart-row')));
        });
    });
});

function placeOrder() {
    window.location.href = '{{ url("payment/index") }}';
}
</script>

@endsection