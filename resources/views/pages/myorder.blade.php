@extends('layout.layout')
@section('content')

<div class="account-page">
    @include('layout.sidebar')

    <main class="account-main">
        <div class="account-section">
            <div class="section-header">
                <h2>Quản Lý Đơn Hàng</h2>
                <p>Theo dõi và kiểm tra trạng thái đơn hàng của bạn</p>
            </div>
            <div class="section-divider"></div>

            {{-- Search + Filter bar --}}
            <div class="order-toolbar">
                <form method="GET" action="{{ route('customer.orders') }}" class="order-search">
                    <div class="search-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <input type="text" name="search" placeholder="Tìm theo địa chỉ..."
                            value="{{ request('search') }}">
                        {{-- Giữ sort khi search --}}
                        <input type="hidden" name="sort"  value="{{ request('sort', 'ORDER_DATE') }}">
                        <input type="hidden" name="dir"   value="{{ request('dir',  'desc') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    </div>
                    <button type="submit" class="btn-save">Tìm kiếm</button>
                </form>

                {{-- Filter trạng thái --}}
                <div class="status-filters">
                    @php
                        $statuses = ['' => 'Tất cả', 'PAID' => 'Đã thanh toán', 'UNPAID' => 'Chưa thanh toán'];
                        $curStatus = request('status', '');
                    @endphp
                    @foreach($statuses as $val => $label)
                        <a href="{{ route('customer.orders', array_merge(request()->query(), ['status' => $val, 'page' => 1])) }}"
                           class="status-filter-btn {{ $curStatus === $val ? 'active' : '' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Orders --}}
            @if($list_order->isEmpty())
                <div class="empty-order">
                    <img src="https://static.vecteezy.com/system/resources/thumbnails/013/281/925/small_2x/basket-retail-shopping-cart-blue-icon-on-abstract-cloud-background-free-vector.jpg" alt="No order">
                    <p>Không có đơn hàng nào</p>
                </div>
            @else
                @php
                    $sort = request('sort', 'ORDER_DATE');
                    $dir  = request('dir',  'desc');
                    $nextDir = $dir === 'asc' ? 'desc' : 'asc';

                    // Helper tạo URL sort
                    $sortUrl = fn($col) => route('customer.orders', array_merge(request()->query(), [
                        'sort' => $col,
                        'dir'  => ($sort === $col) ? $nextDir : 'desc',
                    ]));

                    // Icon mũi tên
                    $sortIcon = fn($col) => $sort === $col
                        ? ($dir === 'asc' ? '↑' : '↓')
                        : '<span style="opacity:.3">↕</span>';
                @endphp

                <div class="order-table-wrap">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ $sortUrl('ORDER_ID') }}" class="sort-link">
                                        # {!! $sortIcon('ORDER_ID') !!}
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ $sortUrl('ORDER_DATE') }}" class="sort-link">
                                        Ngày đặt {!! $sortIcon('ORDER_DATE') !!}
                                    </a>
                                </th>
                                <th>Địa chỉ</th>
                                <th>
                                    <a href="{{ $sortUrl('PAYMENT_STATUS') }}" class="sort-link">
                                        Trạng thái {!! $sortIcon('PAYMENT_STATUS') !!}
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ $sortUrl('TOTAL_PRICE') }}" class="sort-link">
                                        Tổng tiền {!! $sortIcon('TOTAL_PRICE') !!}
                                    </a>
                                </th>
                                <th>Thanh toán</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list_order as $item)
                                <tr>
                                    <td class="order-id">{{ $item->ORDER_ID }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->ORDER_DATE)->format('d/m/Y') }}</td>
                                    <td class="order-address">{{ $item->ADDRESS }}</td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($item->PAYMENT_STATUS ?? 'unpaid') }}">
                                            {{ $item->PAYMENT_STATUS === 'PAID' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                        </span>
                                    </td>
                                    <td class="order-price">{{ number_format($item->TOTAL_PRICE, 0, ',', '.') }}đ</td>
                                    <td>{{ $item->PAYMENT_TYPE }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Tổng kết --}}
                <div class="order-summary">
                    Hiển thị <strong>{{ $list_order->count() }}</strong> đơn hàng
                    @if(request('search'))
                        · Tìm kiếm: "<em>{{ request('search') }}</em>"
                    @endif
                </div>
            @endif
        </div>
    </main>
</div>

<style>
* { box-sizing: border-box; }
.account-page { display: flex; min-height: 100vh; background: #faf8f6; font-family: 'Be Vietnam Pro', 'Roboto', sans-serif; }
.account-main { flex: 1; padding: 40px 48px; }
.section-header h2 { font-size: 22px; font-weight: 700; color: #2d2420; margin: 0 0 4px; }
.section-header p { font-size: 13px; color: #9b8b82; margin: 0; }
.section-divider { height: 1px; background: #ede8e4; margin: 20px 0 28px; }

/* Toolbar */
.order-toolbar { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; }

.order-search { display: flex; gap: 10px; }
.search-wrap {
    display: flex; align-items: center; gap: 8px;
    border: 1px solid #e0d8d2; border-radius: 6px;
    padding: 0 12px; background: #fff; width: 280px;
}
.search-wrap input { border: none; outline: none; font-size: 13.5px; color: #2d2420; padding: 9px 0; width: 100%; background: transparent; }

.btn-save { background: #c0392b; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-size: 13.5px; font-weight: 600; cursor: pointer; transition: background .15s; white-space: nowrap; }
.btn-save:hover { background: #a93226; }

/* Status filter pills */
.status-filters { display: flex; gap: 8px; }
.status-filter-btn {
    padding: 7px 14px; border-radius: 20px; font-size: 12.5px; font-weight: 500;
    border: 1.5px solid #e0d8d2; color: #5a4a42; text-decoration: none;
    background: #fff; transition: all .15s; white-space: nowrap;
}
.status-filter-btn:hover { border-color: #c0392b; color: #c0392b; }
.status-filter-btn.active { background: #c0392b; border-color: #c0392b; color: #fff; }

/* Empty */
.empty-order { display: flex; flex-direction: column; align-items: center; gap: 16px; padding: 60px 0; color: #b0a49c; }
.empty-order img { width: 140px; opacity: .7; }
.empty-order p { font-size: 15px; font-weight: 500; }

/* Table */
.order-table-wrap { overflow-x: auto; border-radius: 10px; border: 1px solid #ede8e4; background: #fff; }
.order-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.order-table thead tr { background: #faf7f5; border-bottom: 1px solid #ede8e4; }
.order-table th { padding: 12px 16px; text-align: left; font-weight: 600; color: #5a4a42; font-size: 12.5px; text-transform: uppercase; letter-spacing: .04em; white-space: nowrap; }
.order-table td { padding: 13px 16px; color: #2d2420; border-bottom: 1px solid #f5f0ec; }
.order-table tbody tr:last-child td { border-bottom: none; }
.order-table tbody tr:hover { background: #fdf8f6; }

/* Sort link */
.sort-link { color: #5a4a42; text-decoration: none; display: flex; align-items: center; gap: 4px; font-weight: 600; font-size: 12.5px; }
.sort-link:hover { color: #c0392b; }

.order-id { font-weight: 600; color: #9b6b4a; }
.order-address { max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.order-price { font-weight: 600; }

/* Status badge */
.status-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.status-paid   { background: #edfaf1; color: #1e8449; }
.status-unpaid { background: #fef9e7; color: #b7770d; }

/* Summary */
.order-summary { margin-top: 14px; font-size: 13px; color: #9b8b82; }
</style>

@stop