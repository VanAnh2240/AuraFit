<link rel="stylesheet" href="{{asset('frontend/css/home.css')}}">

<style>
/* ════════════════════════════════════════════════════════
   COLLECTIONS — TAB NAV
   ════════════════════════════════════════════════════════ */

/* Hàng 1: Category lớn */
.cat-nav-row1 {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 0;
    border-bottom: 2px solid #e8e8e8;
}

.cat-nav-row1 > li {
    cursor: pointer;
    padding: 9px 20px;
    font-size: 15px;
    font-weight: 600;
    color: #666;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: color 0.18s, border-color 0.18s;
    white-space: nowrap;
    user-select: none;
}

.cat-nav-row1 > li:hover,
.cat-nav-row1 > li.is-active {
    color: #3d7ab5;
    border-bottom-color: #3d7ab5;
}

/* Hàng 2: Sub-category — chỉ 1 ul được hiện tại 1 thời điểm */
.cat-nav-row2 {
    position: relative;       /* chứa tất cả ul con */
    border-bottom: 1px solid #e8e8e8;
    margin-bottom: 28px;
    min-height: 38px;
}

.cat-nav-row2 ul {
    list-style: none;
    padding: 0;
    margin: 0;
    position: absolute;       /* chồng lên nhau, chỉ visible mới thấy */
    top: 0; left: 0;
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 0;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.18s;
}

.cat-nav-row2 ul.is-visible {
    opacity: 1;
    pointer-events: auto;
    position: relative;       /* khi visible thì chiếm không gian bình thường */
}

.cat-nav-row2 ul li {
    cursor: pointer;
    padding: 7px 16px;
    font-size: 13.5px;
    font-weight: 500;
    color: #666;
    border-bottom: 2px solid transparent;
    margin-bottom: -1px;
    transition: color 0.15s, border-color 0.15s;
    white-space: nowrap;
    user-select: none;
}

.cat-nav-row2 ul li:hover,
.cat-nav-row2 ul li.is-active {
    color: #3d7ab5;
    border-bottom-color: #3d7ab5;
    font-weight: 600;
}

/* ════════════════════════════════════════════════════════
   PRODUCT TAB CONTENT
   ════════════════════════════════════════════════════════ */
.cat-tabs-content .cat-tab {
    display: none;
}
.cat-tabs-content .cat-tab.is-shown {
    display: block;
}

/* ════════════════════════════════════════════════════════
   PRODUCT GRID — 4 cột desktop, responsive
   ════════════════════════════════════════════════════════ */
.product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

@media (max-width: 1199px) {
    .product-grid { grid-template-columns: repeat(4, 1fr); gap: 16px; }
}
@media (max-width: 767px) {
    .product-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
}

/* ════════════════════════════════════════════════════════
   PRODUCT CARD
   ════════════════════════════════════════════════════════ */
.pcard {
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    transition: box-shadow 0.22s, transform 0.22s;
}

.pcard:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,0.11);
    transform: translateY(-3px);
}

/* Ảnh cố định tỉ lệ 3:4 */
.pcard-img {
    display: block;
    width: 100%;
    aspect-ratio: 3 / 4;
    overflow: hidden;
    background: #f0eeec;
    flex-shrink: 0;
}

.pcard-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.38s ease;
}

.pcard:hover .pcard-img img {
    transform: scale(1.05);
}

/* Info */
.pcard-info {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 10px 12px 13px;
    flex: 1;
}

.pcard-name {
    font-size: 13.5px;
    font-weight: 600;
    color: #1a1a1a;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-decoration: none;
}

.pcard-name:hover { color: #3d7ab5; }

/* Ô màu */
.pcard-colors {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 5px;
}

.cdot {
    position: relative;
    width: 17px;
    height: 17px;
    border-radius: 50%;
    border: 2px solid rgba(0,0,0,0.10);
    flex-shrink: 0;
    transition: transform 0.15s, box-shadow 0.15s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.10);
}

.cdot:hover {
    transform: scale(1.3);
    box-shadow: 0 2px 8px rgba(0,0,0,0.18);
    z-index: 2;
}

.cdot[data-white] { border-color: rgba(0,0,0,0.22); }

/* Tooltip */
.cdot::after {
    content: attr(title);
    position: absolute;
    bottom: calc(100% + 6px);
    left: 50%;
    transform: translateX(-50%);
    background: #1a1a1a;
    color: #fff;
    font-size: 10px;
    font-weight: 500;
    padding: 3px 7px;
    border-radius: 5px;
    white-space: nowrap;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.15s;
    z-index: 10;
}
.cdot:hover::after { opacity: 1; }

.cdot-more {
    background: #f0f0f0 !important;
    border-color: #ddd !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: 700;
    color: #666;
    box-shadow: none;
}

/* Giá */
.pcard-price {
    font-size: 14px;
    font-weight: 700;
    color: #b08d6a;
    margin-top: auto;
    padding-top: 2px;
}
</style>

@extends('layout.user_MainStructure')
@section('title', 'Home')
@section('content')

    <!--==============INTRO==================-->
    <section class="intro py-5">
        <div class="container">
            <div class="row g-5">
                <div class="intro_text col-md-6 col-12">
                    <h1 class="intro_title display-3 mb-3">Shine with AuraFit</h1>
                    <p class="intro_subtitle h5 mb-3">Dịch vụ may đo giúp tự tin tỏa sáng với phong cách của riêng mình</p>
                    <a href="{{route('shop.index')}}"><button class="more-btn">Khám phá ngay</button></a>
                </div>
                <div class="intro_img col-md-6 col-12">
                    <img src="{{asset('frontend/images/intro.png')}}" alt="img">
                </div>
            </div>
        </div>
    </section>

    <!--==============HIGHLIGHT==================-->
    <section class="highlight container py-5">
        <div class="row">
            <div class="bestseller col-sm-6 mb-4 mb-sm-0">
                <div class="card">
                    <img class="card-img" src="{{asset('frontend/images/highlight1.jpg')}}" alt="">
                    <a href="/chat" class="content card-img-overlay">
                        <h3 class="card-title m-1">Gợi ý phối đồ</h3>
                        <h5 class="card-text">Trợ lý thông minh hỗ trợ tìm kiếm trang phục phù hợp</h5>
                    </a>
                </div>
            </div>
            <div class="feature col-sm-6 mb-4 mb-sm-0">
                <div class="card">
                    <img class="card-img" src="{{asset('frontend/images/highlight2.jpg')}}" alt="">
                    <a href="/tryon" class="content card-img-overlay">
                        <h3 class="card-title m-1">Thử đồ ảo</h3>
                        <h5 class="card-text">Xem trước trang phục trước khi đặt may đo</h5>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!--==============PRODUCT COLLECTION==================-->
    {{--
        QUAN TRỌNG: Không dùng class "tab-wrap", "tab-nav", "tab", "visible-content"
        để tránh conflict với home.js cũ.
        Tất cả dùng class riêng: cat-nav-row1/2, cat-tabs-content, cat-tab, is-shown, is-active, is-visible
    --}}
    <section class="products">
        <div class="container p-3 p-md-5">
            <div class="collection-wrap px-md-5">
                <div class="collection-header mb-3">
                    <h2 class="section_title">The Collections</h2>
                    <p>Trải nghiệm dịch vụ may đo chất lượng, tư vấn tận tâm và phong cách riêng tại AuraFit</p>
                </div>

                {{-- ── HÀNG 1: Category lớn ── --}}
                <ul class="cat-nav-row1">
                    @foreach ($categories as $catIdx => $category)
                        @php
                            $firstSubKey = null;
                            foreach ($allCategorySubs as $k => $s) {
                                if ($s->category_id === $category->category_id) { $firstSubKey = $k; break; }
                            }
                        @endphp
                        <li class="{{ $catIdx === 0 ? 'is-active' : '' }}"
                            data-cat-id="{{ $category->category_id }}"
                            data-first-tab="{{ $firstSubKey }}">
                            {{ $category->category_name }}
                        </li>
                    @endforeach
                </ul>

                {{-- ── HÀNG 2: Sub-category — position absolute trick ── --}}
                <div class="cat-nav-row2">
                    @foreach ($categories as $catIdx => $category)
                        <ul class="{{ $catIdx === 0 ? 'is-visible' : '' }}"
                            data-cat-parent="{{ $category->category_id }}">
                            @foreach ($categorySubs[$category->category_id] ?? [] as $subIdx => $sub)
                                @php
                                    $subKey = null;
                                    foreach ($allCategorySubs as $k => $s) {
                                        if ($s->category_sub_id === $sub->category_sub_id) { $subKey = $k; break; }
                                    }
                                @endphp
                                <li class="{{ ($catIdx === 0 && $subIdx === 0) ? 'is-active' : '' }}"
                                    data-goto="{{ $subKey }}">
                                    {{ $sub->category_sub_name }}
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>

                {{-- ── Tab contents ── --}}
                <div class="cat-tabs-content">
                    @foreach ($allCategorySubs as $key => $sub)
                        <div class="cat-tab {{ $key === 0 ? 'is-shown' : '' }}"
                             data-tab-key="{{ $key }}">
                            <div class="product-grid">
                                @if(($products[$sub->category_sub_id] ?? collect())->isEmpty())
                                    <p class="text-muted py-4" style="grid-column:1/-1">Chưa có sản phẩm trong danh mục này.</p>
                                @else
                                    @foreach($products[$sub->category_sub_id] as $product)
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
                                            $colors     = $product->colors ?? collect();
                                            $showColors = $colors->take(5);
                                            $moreCount  = max(0, $colors->count() - 5);
                                        @endphp
                                        <div class="pcard">
                                            <a href="{{ route('product.detail', $product->product_id) }}" class="pcard-img">
                                                <img src="{{ $product->image_link }}" alt="{{ $product->name }}" loading="lazy">
                                            </a>
                                            <div class="pcard-info">
                                                <a href="{{ route('product.detail', $product->product_id) }}" class="pcard-name">
                                                    {{ $product->name }}
                                                </a>

                                                @if($colors->count())
                                                    <div class="pcard-colors">
                                                        @foreach($showColors as $color)
                                                            <span class="cdot {{ $color->type_en === 'White' ? 'cdot-white' : '' }}"
                                                                  {{ $color->type_en === 'White' ? 'data-white' : '' }}
                                                                  style="background:{{ $colorMap[$color->type_en] ?? '#ccc' }}"
                                                                  title="{{ $color->color_name_vi }}"></span>
                                                        @endforeach
                                                        @if($moreCount > 0)
                                                            <span class="cdot cdot-more" title="{{ $moreCount }} màu khác">+{{ $moreCount }}</span>
                                                        @endif
                                                    </div>
                                                @endif

                                                <span class="pcard-price">
                                                    {{ number_format($product->price, 0, ',', '.') }}₫
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <a href="/shop" class="view-btn fs-6">Xem thêm</a>
        </div>
    </section>

    <!--==============SALE==================-->
    <section class="sale">
        <div class="container">
            <div class="sale-row row row-cols-1 row-cols-md-3">
                <div class="hotsale col">
                    <div class="list_title">
                        <a href="{{ url('/shop?sort=Most+popular') }}"><h3>HOT SALE</h3></a>
                    </div>
                    <div class="list row row-cols-1 g-3">
                        @foreach ($productsHotSale as $product)
                            <div class="list-item">
                                <div class="list_img col-3">
                                    <a href="{{ route('product.detail', $product->product_id) }}">
                                        <img src="{{ $product->image_link }}" class="img-fluid" alt="{{ $product->name }}">
                                    </a>
                                </div>
                                <div class="list_content">
                                    <span class="product_title fs-5">
                                        <a href="{{ route('product.detail', $product->product_id) }}">{{ $product->name }}</a>
                                    </span>
                                    <span class="product_price fs-6">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="lastest col">
                    <div class="list_title">
                        <a href="{{ url('/shop?sort=Newest') }}"><h3>LATEST</h3></a>
                    </div>
                    <div class="list row row-cols-1 g-3">
                        @foreach ($productsLatest as $product)
                            <div class="list-item">
                                <div class="list_img col-3">
                                    <a href="{{ route('product.detail', $product->product_id) }}">
                                        <img src="{{ $product->image_link }}" class="img-fluid" alt="{{ $product->name }}">
                                    </a>
                                </div>
                                <div class="list_content">
                                    <span class="product_title fs-5">
                                        <a href="{{ route('product.detail', $product->product_id) }}">{{ $product->name }}</a>
                                    </span>
                                    <span class="product_price fs-6">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="banner col-5 col-md-3">
                    <img src="{{ asset('frontend/images/bookmark.jpg') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('frontend/js/home.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
    // Hoàn toàn tách biệt với home.js cũ — dùng class riêng, không đụng .tab-wrap/.tab-nav
    (function () {
        var currentCatId  = null;
        var currentTabKey = null;

        // ── Chuyển tab sản phẩm ────────────────────────────
        function showTab(key) {
            if (String(key) === String(currentTabKey)) return;
            currentTabKey = key;
            document.querySelectorAll('.cat-tabs-content .cat-tab').forEach(function(el) {
                el.classList.toggle('is-shown', String(el.dataset.tabKey) === String(key));
            });
        }

        // ── Highlight sub-item ──────────────────────────────
        function setActiveSub(key) {
            document.querySelectorAll('.cat-nav-row2 li').forEach(function(li) {
                li.classList.toggle('is-active', String(li.dataset.goto) === String(key));
            });
        }

        // ── Hiện sub-list của category ──────────────────────
        function showSubList(catId) {
            if (catId === currentCatId) return;
            currentCatId = catId;
            document.querySelectorAll('.cat-nav-row2 ul').forEach(function(ul) {
                var show = ul.dataset.catParent === catId;
                ul.classList.toggle('is-visible', show);
            });
        }

        // ── HÀNG 1: click ───────────────────────────────────
        document.querySelectorAll('.cat-nav-row1 li').forEach(function(li) {
            // Hover: preview sub-list
            li.addEventListener('mouseenter', function() {
                showSubList(this.dataset.catId);
            });
            li.addEventListener('mouseleave', function() {
                // Trả về cat đang active khi bỏ chuột
                var activeLi = document.querySelector('.cat-nav-row1 li.is-active');
                if (activeLi) showSubList(activeLi.dataset.catId);
            });

            // Click: active + chuyển tab đầu tiên
            li.addEventListener('click', function() {
                document.querySelectorAll('.cat-nav-row1 li').forEach(function(i) { i.classList.remove('is-active'); });
                this.classList.add('is-active');
                showSubList(this.dataset.catId);
                var firstKey = this.dataset.firstTab;
                showTab(firstKey);
                setActiveSub(firstKey);
            });
        });

        // ── HÀNG 2: click sub ───────────────────────────────
        document.querySelectorAll('.cat-nav-row2 li').forEach(function(li) {
            li.addEventListener('click', function() {
                showTab(this.dataset.goto);
                setActiveSub(this.dataset.goto);
            });
        });

        // ── Init ─────────────────────────────────────────────
        var firstCat = document.querySelector('.cat-nav-row1 li');
        if (firstCat) {
            currentCatId = firstCat.dataset.catId;
        }
        showTab(0);
        setActiveSub(0);
    })();
    </script>
@endsection