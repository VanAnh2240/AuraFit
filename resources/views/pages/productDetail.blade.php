<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<link rel="stylesheet" href="{{ asset('frontend/css/product_detail.css') }}">

<style>
/* ── Gallery fix: scrollable thumbs + no image distortion ── */

.pd-gallery {
    display: flex;
    flex-direction: row;
    gap: 12px;
    align-items: flex-start;
}

/* Cột thumbnails dọc – cuộn được */
.pd-thumbs {
    display: flex;
    flex-direction: column;
    gap: 8px;
    width: 72px;
    flex-shrink: 0;

    /* Chiều cao khớp với ảnh chính, scroll nếu nhiều thumb */
    max-height: 520px;
    overflow-y: auto;
    overflow-x: hidden;

    /* Ẩn thanh cuộn mặc định nhưng vẫn cuộn được */
    scrollbar-width: thin;
    scrollbar-color: #ccc transparent;
    padding-right: 2px;
}

.pd-thumbs::-webkit-scrollbar {
    width: 4px;
}
.pd-thumbs::-webkit-scrollbar-track {
    background: transparent;
}
.pd-thumbs::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 4px;
}

/* Mỗi nút thumbnail */
.pd-thumb {
    flex-shrink: 0;
    width: 68px;
    height: 86px;           /* tỉ lệ 3:4 */
    border: 2px solid transparent;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
    padding: 0;
    background: #f5f5f5;
    transition: border-color .2s;
}

.pd-thumb.active,
.pd-thumb:hover {
    border-color: #222;
}

.pd-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;      /* thumb nhỏ dùng cover là ổn */
    display: block;
}

/* Ảnh chính – KHÔNG bóp méo */
.pd-main-img-wrap {
    flex: 1;
    min-width: 0;
    aspect-ratio: 3 / 4;   /* giữ tỉ lệ chuẩn */
    max-height: 520px;
    border-radius: 10px;
    overflow: hidden;
    background: #f8f8f8;
    display: flex;
    align-items: center;
    justify-content: center;
}

#pdMainImg {
    width: 100%;
    height: 100%;
    object-fit: contain;    /* ← KEY: giữ nguyên tỉ lệ, không crop, không méo */
    display: block;
    transition: opacity .18s ease;
}

/* Responsive: mobile chuyển thumbs ra dưới nằm ngang */
@media (max-width: 600px) {
    .pd-gallery {
        flex-direction: column;
    }

    .pd-thumbs {
        flex-direction: row;
        width: 100%;
        max-height: none;
        overflow-x: auto;
        overflow-y: hidden;
        padding-right: 0;
        padding-bottom: 2px;
    }

    .pd-thumbs::-webkit-scrollbar {
        height: 4px;
        width: auto;
    }

    .pd-thumb {
        width: 60px;
        height: 75px;
        flex-shrink: 0;
    }

    .pd-main-img-wrap {
        max-height: 360px;
        aspect-ratio: 3 / 4;
    }
}
</style>


@extends('layout.user_MainStructure')
@section('title', $product->name)
@section('content')

@php
$colorMap = [
    'White'  => '#F5F5F5',
    'Gray'   => '#9E9E9E',
    'Black'  => '#212121',
    'Red'    => '#E53935',
    'Orange' => '#FB8C00',
    'Brown'  => '#795548',
    'Yellow' => '#FDD835',
    'Green'  => '#43A047',
    'Blue'   => '#1E88E5',
    'Purple' => '#8E24AA',
];
$sizes = ['S', 'M', 'L', 'XL'];
@endphp

<div class="container">

    {{-- Breadcrumb --}}
    <nav class="pd-breadcrumb">
        <a href="{{ route('home') }}">Trang chủ</a>
        <span>/</span>
        @if($categorySub)
            <a href="/shop?category_sub={{ $product->category_sub_id }}">{{ $categorySub->category_sub_name }}</a>
            <span>/</span>
        @endif
        <span style="color:#444">{{ $product->name }}</span>
    </nav>

    {{-- MAIN: ảnh trái + info phải --}}
    <div class="pd-main">

        {{-- ── GALLERY ── --}}
        <div class="pd-gallery">
            {{-- Thumbnail dọc --}}
            <div class="pd-thumbs">
                @foreach($images as $i => $img)
                    <button class="pd-thumb {{ $i === 0 ? 'active' : '' }}"
                            onclick="switchImage(this, '{{ $img->image_link }}')"
                            data-color-code="{{ $img->color_code }}"
                            type="button">
                        <img src="{{ $img->image_link }}" alt="ảnh {{ $i+1 }}" loading="lazy">
                    </button>
                @endforeach
            </div>

            {{-- Ảnh chính --}}
            <div class="pd-main-img-wrap">
                <img id="pdMainImg" src="{{ $mainImage }}" alt="{{ $product->name }}">
            </div>
        </div>

        {{-- ── INFO PANEL (sticky) ── --}}
        <div class="pd-info">

            @if($categorySub)
                <span class="pd-badge">{{ $categorySub->category_sub_name }}</span>
            @endif

            <h1 class="pd-name">{{ $product->name }}</h1>

            <div class="pd-price-row">
                <span class="pd-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
            </div>

            {{-- Màu sắc --}}
            @if($colors->count())
                <div class="mb-3">
                    <div class="pd-section-label">
                        Màu sắc
                        <span class="pd-color-name" id="selectedColorName">{{ $colors->first()->color_name_vi }}</span>
                    </div>
                    <div class="pd-colors">
                        @foreach($colors as $i => $color)
                            <button type="button"
                                    class="pd-color-btn {{ $i === 0 ? 'active' : '' }}"
                                    {{ $color->type_en === 'White' ? 'data-white' : '' }}
                                    style="background: {{ $colorMap[$color->type_en] ?? '#ccc' }}"
                                    data-color-name="{{ $color->color_name_vi }}"
                                    data-color-code="{{ $color->color_code }}"
                                    title="{{ $color->color_name_vi }}"
                                    onclick="selectColor(this)">
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Size --}}
            <div class="mb-4">
                <div class="pd-section-label">Kích cỡ</div>
                <div class="pd-sizes">
                    @foreach($sizes as $i => $size)
                        <button type="button"
                                class="pd-size-btn {{ $i === 0 ? 'active' : '' }}"
                                onclick="selectSize(this)">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Chất liệu --}}
            @if(!empty($product->composition))
                <div class="mb-1">
                    <div class="pd-section-label">Chất liệu</div>
                    <div class="pd-composition">{{ $product->composition }}</div>
                </div>
            @endif

            {{-- Số lượng --}}
            <div class="pd-qty-row">
                <span class="pd-qty-label">Số lượng</span>
                <div class="pd-qty-ctrl">
                    <button type="button" onclick="changeQty(-1)">−</button>
                    <input type="number" id="pdQty" value="1" min="1" max="99" readonly>
                    <button type="button" onclick="changeQty(1)">+</button>
                </div>
            </div>

            {{-- Nút hành động --}}
            @auth
                <form action="{{ route('product.addtocart', $product->product_id) }}" method="POST" id="pdCartForm">
                @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="hidden" name="count" id="pdQtyInput" value="1">

                    <div class="pd-actions">
                        <button type="submit" class="pd-btn-cart">
                            <i class="bx bx-cart-add" style="font-size:18px;"></i>
                            Thêm giỏ hàng
                        </button>
                        <button type="button" class="pd-btn-buy"
                                onclick="document.getElementById('pdCartForm').submit()">
                            Mua ngay
                        </button>
                    </div>
                </form>
            @else
                <div class="pd-actions">
                    <a href="{{ route('login') }}" class="pd-btn-cart" style="display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;">
                        <i class="bx bx-cart-add" style="font-size:18px;"></i>
                        Đăng nhập để mua
                    </a>
                </div>
            @endauth

            <a href="/tryon?product={{ $product->product_id }}" class="pd-btn-tryon mt-2">
                <i class="bx bx-camera" style="font-size:17px;"></i>
                Thử đồ ảo
            </a>

            @if(session('success'))
                <script>showToast("{{ session('success') }}")</script>
            @endif
        </div>
    </div>

    {{-- ── MÔ TẢ SẢN PHẨM ── --}}
    @if(!empty($product->description))
        <div class="pd-desc-section">
            <h3>Mô tả sản phẩm</h3>
            <div class="pd-description">{{ $product->description }}</div>
        </div>
    @endif

    {{-- ── SẢN PHẨM TƯƠNG TỰ ── --}}
    @if($similarProducts->count())
        <div class="pd-similar-section">
            <div class="pd-similar-header">
                <h3>Sản phẩm tương tự</h3>
                <a href="/shop?category_sub={{ $product->category_sub_id }}">Xem tất cả →</a>
            </div>
            <div class="pd-similar-grid">
                @foreach($similarProducts as $sim)
                    @php
                        $simColors     = $sim->colors ?? collect();
                        $simShowColors = $simColors->take(4);
                        $simMore       = max(0, $simColors->count() - 4);
                    @endphp
                    <a href="{{ route('product.detail', $sim->product_id) }}" class="sim-card">
                        <div class="sim-card-img">
                            <img src="{{ $sim->image_link }}" alt="{{ $sim->name }}" loading="lazy">
                        </div>
                        <div class="sim-card-info">
                            <span class="sim-card-name">{{ $sim->name }}</span>
                            @if($simColors->count())
                                <div class="sim-card-colors">
                                    @foreach($simShowColors as $sc)
                                        <span class="sim-cdot"
                                              style="background:{{ $colorMap[$sc->type_en] ?? '#ccc' }}"
                                              title="{{ $sc->color_name_vi }}"></span>
                                    @endforeach
                                    @if($simMore > 0)
                                        <span style="font-size:10px;color:#888;align-self:center;">+{{ $simMore }}</span>
                                    @endif
                                </div>
                            @endif
                            <span class="sim-card-price">{{ number_format($sim->price, 0, ',', '.') }}₫</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

{{-- Toast notification --}}
<div class="pd-toast" id="pdToast"></div>

<script>
// ── Map color_code → image src (build từ thumbnails) ───
var colorImageMap = {};
document.querySelectorAll('.pd-thumb').forEach(function(thumb) {
    var code = thumb.dataset.colorCode;
    var src  = thumb.querySelector('img').src;
    if (code !== undefined && !colorImageMap[code]) {
        colorImageMap[code] = src;
    }
});

// ── Chuyển ảnh chính ───────────────────────────────────
function switchImage(thumb, src) {
    document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
    setMainImage(src);
}

function setMainImage(src) {
    var img = document.getElementById('pdMainImg');
    img.style.opacity = '0';
    setTimeout(function() {
        img.src = src;
        img.style.opacity = '1';
    }, 180);
}

// ── Chọn màu → nhảy ảnh tương ứng ─────────────────────
function selectColor(btn) {
    document.querySelectorAll('.pd-color-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('selectedColorName').textContent = btn.dataset.colorName;

    var code = btn.dataset.colorCode;

    var matchThumb = null;
    document.querySelectorAll('.pd-thumb').forEach(function(thumb) {
        var match = (thumb.dataset.colorCode === code);
        thumb.classList.toggle('active', match);
        if (match && !matchThumb) matchThumb = thumb;
    });

    if (matchThumb) {
        matchThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        setMainImage(matchThumb.querySelector('img').src);
    } else if (colorImageMap[code]) {
        setMainImage(colorImageMap[code]);
    }
}

// ── Chọn size ──────────────────────────────────────────
function selectSize(btn) {
    document.querySelectorAll('.pd-size-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

// ── Số lượng ───────────────────────────────────────────
function changeQty(delta) {
    var input = document.getElementById('pdQty');
    var hidden = document.getElementById('pdQtyInput');
    var val = Math.max(1, Math.min(99, parseInt(input.value) + delta));
    input.value = val;
    if (hidden) hidden.value = val;
}

// ── Toast ──────────────────────────────────────────────
function showToast(msg) {
    var t = document.getElementById('pdToast');
    if (!t) return;
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(function() { t.classList.remove('show'); }, 2800);
}

@if(session('success'))
    window.addEventListener('DOMContentLoaded', function() {
        showToast("{{ session('success') }}");
    });
@endif
</script>

@endsection
