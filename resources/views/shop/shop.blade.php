@php
    $colorMap = [
        'White'  => '#F5F5F5', 'Gray'   => '#9E9E9E', 'Black'  => '#212121',
        'Red'    => '#E53935', 'Orange' => '#FB8C00', 'Brown'  => '#795548',
        'Yellow' => '#FDD835', 'Green'  => '#43A047', 'Blue'   => '#1E88E5',
        'Purple' => '#8E24AA', 'Pink'   => '#E91E8C', 'Beige'  => '#D7C4A3',
    ];
@endphp

@if($products->isEmpty())
    <div class="empty-state">
        <i class='bx bx-package'></i>
        Không tìm thấy sản phẩm phù hợp.
    </div>
@else
    <div class="product-grid">
        @foreach($products as $product)
            @php
                $img        = $product->images->first()->image_link ?? $product->images->first()->IMAGE_LINK ?? '';
                $colors     = $product->colors ?? collect();
                $showColors = $colors->take(5);
                $moreCount  = max(0, $colors->count() - 5);
            @endphp
            <a href="{{ route('product.detail', $product->product_id) }}" class="pcard">
                <div class="pcard-img">
                    <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy">
                </div>
                <div class="pcard-info">
                    <span class="pcard-name">{{ $product->name }}</span>

                    @if($colors->count())
                        <div class="pcard-colors">
                            @foreach($showColors as $color)
                                <span class="cdot {{ ($color->type_en ?? '') === 'White' ? 'cdot-white' : '' }}"
                                      style="background:{{ $colorMap[$color->type_en ?? ''] ?? '#ccc' }}"
                                      title="{{ $color->color_name_vi ?? $color->type_en ?? '' }}"></span>
                            @endforeach
                            @if($moreCount > 0)
                                <span class="cdot cdot-more" title="{{ $moreCount }} màu khác">+{{ $moreCount }}</span>
                            @endif
                        </div>
                    @endif

                    <span class="pcard-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                </div>
            </a>
        @endforeach
    </div>
@endif