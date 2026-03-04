@extends('layout.user_MainStructure')

@section('title', 'Cửa hàng - AuraFit')

@section('content')

<style>
/* ══════════════════════════════════════════
   SHOP PAGE
══════════════════════════════════════════ */
.shop-page {
    display: flex;
    gap: 0;
    min-height: 80vh;
    padding: 2rem 0 4rem;
}

/* ── Sidebar ── */
.shop-sidebar {
    width: 240px;
    flex-shrink: 0;
    padding: 1.5rem 1.25rem;
    border-right: 1px solid #f0e8f4;
    background: #fdf9ff;
}

.sidebar-title {
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #b49ab0;
    margin-bottom: 1.25rem;
}

.filter-group { margin-bottom: 1.5rem; }

.filter-group-label {
    font-size: .78rem;
    font-weight: 700;
    color: var(--main-color-dark, #39245F);
    letter-spacing: .06em;
    text-transform: uppercase;
    margin-bottom: .6rem;
    display: flex;
    align-items: center;
    gap: .4rem;
}

.filter-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: .3rem;
}

.filter-list li label {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .84rem;
    color: #5a4a5a;
    cursor: pointer;
    padding: .3rem .4rem;
    border-radius: .4rem;
    transition: background .15s;
}

.filter-list li label:hover { background: #f3e8fb; }

.filter-list input[type="checkbox"] {
    accent-color: var(--main-color, #8b2f7a);
    width: 14px;
    height: 14px;
    flex-shrink: 0;
}

.filter-list li label.active { color: var(--main-color, #8b2f7a); font-weight: 600; }

/* Sub-category toggle */
.cat-toggle {
    cursor: pointer;
    user-select: none;
}

.cat-toggle .arrow {
    margin-left: auto;
    font-size: .7rem;
    transition: transform .2s;
    color: #b49ab0;
}

.cat-toggle.open .arrow { transform: rotate(180deg); }

.sub-list {
    display: none;
    padding-left: 1rem;
    margin-top: .2rem;
}

.sub-list.open { display: flex; flex-direction: column; gap: .2rem; }

/* Price chips */
.price-chips {
    display: flex;
    flex-direction: column;
    gap: .3rem;
}

.price-chip {
    padding: .3rem .75rem;
    border-radius: 2rem;
    border: 1.5px solid #e8d8f0;
    background: transparent;
    font-size: .8rem;
    color: #5a4a5a;
    cursor: pointer;
    text-align: left;
    transition: all .18s;
}

.price-chip:hover, .price-chip.active {
    background: var(--main-color, #8b2f7a);
    border-color: var(--main-color, #8b2f7a);
    color: white;
}

/* ── Main content ── */
.shop-main {
    flex: 1;
    min-width: 0;
    padding: 0 1.5rem;
}

/* Toolbar */
.shop-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
    gap: .75rem;
}

.shop-toolbar .result-count {
    font-size: .85rem;
    color: #b49ab0;
}

.shop-toolbar .result-count span { font-weight: 700; color: var(--main-color-dark, #39245F); }

/* Search bar inside toolbar */
.shop-search-form {
    display: flex;
    align-items: center;
    background: #f8f0fc;
    border-radius: 2rem;
    padding: .3rem .4rem .3rem 1rem;
    gap: .4rem;
    border: 1.5px solid transparent;
    transition: border-color .2s;
}

.shop-search-form:focus-within { border-color: var(--main-color, #8b2f7a); }

.shop-search-form input {
    background: transparent;
    border: none;
    outline: none;
    font-size: .85rem;
    color: var(--main-color-dark, #39245F);
    width: 180px;
}

.shop-search-form input::placeholder { color: #c4a0c4; }

.shop-search-form button {
    background: var(--main-color, #8b2f7a);
    border: none;
    border-radius: 2rem;
    padding: .3rem .8rem;
    color: white;
    font-size: .8rem;
    cursor: pointer;
    transition: background .2s;
}

.shop-search-form button:hover { background: var(--main-color-light, #cc94d5); }

/* Sort dropdown */
.sort-btn {
    background: #f8f0fc;
    border: 1.5px solid #e8d8f0;
    border-radius: 2rem;
    padding: .35rem 1rem;
    font-size: .83rem;
    font-weight: 600;
    color: var(--main-color-dark, #39245F);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: .4rem;
    transition: all .18s;
}

.sort-btn:hover { border-color: var(--main-color, #8b2f7a); }

.dropdown-menu { border-radius: .75rem; border: 1px solid #f0e0f0; box-shadow: 0 8px 24px rgba(120,60,130,.1); }
.dropdown-item { font-size: .85rem; }
.dropdown-item:hover { background: #f8f0fc; color: var(--main-color, #8b2f7a); }
.dropdown-item.active { background: var(--main-color, #8b2f7a); }

/* ── Product Grid ── */
.product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}

@media (max-width: 1199px) { .product-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 767px)  { .product-grid { grid-template-columns: repeat(2, 1fr); } }

.pcard {
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    transition: box-shadow .22s, transform .22s;
    text-decoration: none;
}

.pcard:hover {
    box-shadow: 0 8px 28px rgba(120,60,130,.13);
    transform: translateY(-3px);
}

.pcard-img {
    display: block;
    width: 100%;
    aspect-ratio: 3 / 4;
    overflow: hidden;
    background: #f0eeec;
}

.pcard-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .38s ease;
}

.pcard:hover .pcard-img img { transform: scale(1.05); }

.pcard-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding: 10px 12px 13px;
    flex: 1;
}

.pcard-name {
    font-size: 13px;
    font-weight: 600;
    color: #1a1a1a;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-decoration: none;
}

.pcard-colors {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

.cdot {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 2px solid rgba(0,0,0,.1);
    transition: transform .15s;
    position: relative;
}

.cdot:hover { transform: scale(1.3); z-index: 2; }

.cdot::after {
    content: attr(title);
    position: absolute;
    bottom: calc(100% + 5px);
    left: 50%;
    transform: translateX(-50%);
    background: #1a1a1a;
    color: #fff;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 4px;
    white-space: nowrap;
    pointer-events: none;
    opacity: 0;
    transition: opacity .15s;
}

.cdot:hover::after { opacity: 1; }

.cdot-more {
    background: #f0f0f0 !important;
    border-color: #ddd !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8px;
    font-weight: 700;
    color: #666;
}

.pcard-price {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--main-color, #8b2f7a);
    margin-top: auto;
}

/* ── Pagination ── */
.pagination-wrap { margin-top: 2rem; }

.pagination .page-link {
    border-radius: .5rem !important;
    margin: 0 2px;
    border: 1.5px solid #f0e0f0;
    color: var(--main-color-dark, #39245F);
    font-size: .85rem;
}

.pagination .page-item.active .page-link {
    background: var(--main-color, #8b2f7a);
    border-color: var(--main-color, #8b2f7a);
}

.pagination .page-link:hover { background: #f8f0fc; }

/* Empty state */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #b49ab0;
    grid-column: 1 / -1;
}

.empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; }

@media (max-width: 767px) {
    .shop-sidebar { display: none; }
    .shop-main { padding: 0 .75rem; }
}
</style>

<div class="container-fluid px-3 px-md-5">
    <div class="shop-page">

        {{-- ══ SIDEBAR ══ --}}
        <aside class="shop-sidebar">
            <div class="sidebar-title"><i class='bx bx-filter-alt me-1'></i> Bộ lọc</div>

            {{-- Danh mục --}}
            <div class="filter-group">
                <div class="filter-group-label"><i class='bx bx-category-alt'></i> Danh mục</div>
                @foreach($categories as $cat)
                    @php $subs = $categorySubs[$cat->category_id] ?? collect(); @endphp
                    @if($subs->count())
                        <div class="cat-toggle mb-1" data-target="sub-{{ $cat->category_id }}">
                            <label style="display:flex; align-items:center; gap:.4rem; font-size:.85rem; font-weight:600; color:#5a4a5a; cursor:pointer; padding:.3rem .4rem;">
                                {{ $cat->category_name }}
                                <span class="arrow ms-auto">▼</span>
                            </label>
                        </div>
                        <ul class="filter-list sub-list" id="sub-{{ $cat->category_id }}">
                            @foreach($subs as $sub)
                                <li>
                                    <label>
                                        <input type="checkbox"
                                               class="filter-sub"
                                               value="{{ $sub->category_sub_id }}"
                                               {{ in_array($sub->category_sub_id, $selectedSubs) ? 'checked' : '' }}>
                                        {{ $sub->category_sub_name }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </div>

            {{-- Giá --}}
            <div class="filter-group">
                <div class="filter-group-label"><i class='bx bx-purchase-tag'></i> Khoảng giá</div>
                <div class="price-chips">
                    @php
                        $priceRanges = [
                            ''          => 'Tất cả',
                            '0-200'     => 'Dưới 200₫',
                            '200-500'   => '200₫ – 500₫',
                            '500-800'   => '500₫ – 800₫',
                            '800-1200'  => '800₫ – 1.200₫',
                            '1200-99999999' => 'Trên 1.200₫',
                        ];
                    @endphp
                    @foreach($priceRanges as $val => $label)
                        <button class="price-chip filter-price {{ $selectedPrice === $val ? 'active' : '' }}"
                                data-value="{{ $val }}">{{ $label }}</button>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- ══ MAIN ══ --}}
        <div class="shop-main">

            {{-- Toolbar --}}
            <div class="shop-toolbar">
                <p class="result-count mb-0">
                    Tìm thấy <span>{{ $products->total() }}</span> sản phẩm
                    @isset($keyword) cho "<em>{{ $keyword }}</em>" @endisset
                </p>

                <div class="d-flex align-items-center gap-2">
                    {{-- Tìm kiếm --}}
                    <form action="{{ route('shop.search') }}" method="POST" class="shop-search-form">
                        @csrf
                        <input name="search" placeholder="Tìm sản phẩm..."
                               value="{{ $keyword ?? '' }}" maxlength="100">
                        <button type="submit"><i class='bx bx-search'></i></button>
                    </form>

                    {{-- Sắp xếp --}}
                    <div class="dropdown">
                        <button class="sort-btn dropdown-toggle" id="sortBtn"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-sort'></i>
                            <span id="sort-label">Mới nhất</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" data-value="Newest">Mới nhất</a></li>
                            <li><a class="dropdown-item" data-value="Price (low to high)">Giá tăng dần</a></li>
                            <li><a class="dropdown-item" data-value="Price (high to low)">Giá giảm dần</a></li>
                            <li><a class="dropdown-item" data-value="Most popular">Phổ biến nhất</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Product grid --}}
            <div id="product-list">
                @include('shop.shop', ['products' => $products])
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrap">
                {{ $products->links() }}
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const CSRF = "{{ csrf_token() }}";
    let currentSort  = 'Newest';
    let currentPrice = '{{ $selectedPrice }}';
    let currentSubs  = {{ json_encode($selectedSubs) }};

    // ── Category sub toggle ──────────────────────────────────────────
    document.querySelectorAll('.cat-toggle').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const id  = this.dataset.target;
            const sub = document.getElementById(id);
            sub.classList.toggle('open');
            this.classList.toggle('open');
        });
    });

    // Auto-open nếu có filter đang active
    document.querySelectorAll('.filter-sub:checked').forEach(cb => {
        const subList = cb.closest('.sub-list');
        if (subList) {
            subList.classList.add('open');
            const toggle = document.querySelector(`[data-target="${subList.id}"]`);
            if (toggle) toggle.classList.add('open');
        }
    });

    // ── Price chip ───────────────────────────────────────────────────
    document.querySelectorAll('.price-chip').forEach(chip => {
        chip.addEventListener('click', function () {
            document.querySelectorAll('.price-chip').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            currentPrice = this.dataset.value;
            fetchProducts();
        });
    });

    // ── Category sub checkbox ────────────────────────────────────────
    document.querySelectorAll('.filter-sub').forEach(cb => {
        cb.addEventListener('change', function () {
            currentSubs = Array.from(document.querySelectorAll('.filter-sub:checked'))
                              .map(c => c.value);
            fetchProducts();
        });
    });

    // ── Sort ─────────────────────────────────────────────────────────
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            currentSort = this.dataset.value;
            document.getElementById('sort-label').textContent = this.textContent.trim();
            document.querySelectorAll('.dropdown-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            fetchProducts();
        });
    });

    // ── AJAX fetch ───────────────────────────────────────────────────
    function fetchProducts() {
        const params = new URLSearchParams();
        params.set('sort', currentSort);
        if (currentPrice) params.set('price', currentPrice);
        currentSubs.forEach(s => params.append('category_sub[]', s));

        fetch('{{ route("shop.filter") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': CSRF,
            },
            body: params.toString()
        })
        .then(r => r.json())
        .then(data => {
            document.getElementById('product-list').innerHTML = data.html;
        });
    }
});
</script>

@endsection