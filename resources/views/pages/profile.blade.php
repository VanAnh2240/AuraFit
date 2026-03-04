{{-- resources/views/customer/profile.blade.php --}}

@extends('layout.user_MainStructure')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="account-page">
    @include('layout.sidebar')

    <main class="account-main">
        <div class="account-section">
            <div class="section-header">
                <h2>Thông Tin Cá Nhân</h2>
                <p>Thông tin phong cách và vóc dáng giúp chúng tôi gợi ý trang phục phù hợp hơn</p>
            </div>
            <div class="section-divider"></div>

            @if(session('error'))
                <div class="alert-msg alert-err">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert-msg alert-ok">{{ session('success') }}</div>
            @endif

            <form action="/profile/personal/update/{{ $user->CUSTOMER_ID }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="profile-form-layout">
                    {{-- LEFT COLUMN --}}
                    <div class="profile-fields">

                        {{-- Body measurements --}}
                        <div class="profile-group">
                            <h4 class="group-title">Vóc dáng</h4>
                            <div class="fields-row-2">
                                <div class="field-col">
                                    <label>Cân nặng (kg)</label>
                                    <input type="number" name="weight_kg" step="0.1" min="30" max="200"
                                        class="field-input" placeholder="VD: 52.5"
                                        value="{{ $profile->weight_kg ?? '' }}">
                                </div>
                                <div class="field-col">
                                    <label>Chiều cao (cm)</label>
                                    <input type="number" name="height_cm" step="0.1" min="100" max="220"
                                        class="field-input" placeholder="VD: 160"
                                        value="{{ $profile->height_cm ?? '' }}">
                                </div>
                            </div>
                        </div>

                        {{-- Body shape --}}
                        <div class="profile-group">
                            <h4 class="group-title">Hình dáng cơ thể (Body Shape)</h4>
                            <div class="shape-options">
                                @php
                                    $shapes = [
                                        'HOURGLASS'         => ['label' => 'Đồng hồ cát', 'icon' => '⌛'],
                                        'PEAR'              => ['label' => 'Quả lê',       'icon' => '🍐'],
                                        'APPLE'             => ['label' => 'Quả táo',      'icon' => '🍎'],
                                        'RECTANGLE'         => ['label' => 'Chữ nhật',     'icon' => '▭'],
                                        'INVERTED_TRIANGLE' => ['label' => 'Tam giác ngược','icon' => '▽'],
                                    ];
                                @endphp
                                @foreach($shapes as $val => $info)
                                    <label class="shape-card {{ ($profile->body_shape ?? '') == $val ? 'selected' : '' }}">
                                        <input type="radio" name="body_shape" value="{{ $val }}"
                                            {{ ($profile->body_shape ?? '') == $val ? 'checked' : '' }}>
                                        <span class="shape-icon">{{ $info['icon'] }}</span>
                                        <span class="shape-label">{{ $info['label'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Undertone --}}
                        <div class="profile-group">
                            <h4 class="group-title">Undertone (Tông da)</h4>
                            <div class="tone-options">
                                @php
                                    $undertones = [
                                        'WARM'    => ['label' => 'Warm',    'desc' => 'Ấm – vàng, cam',      'color' => '#e8c98a'],
                                        'COOL'    => ['label' => 'Cool',    'desc' => 'Lạnh – hồng, tím',    'color' => '#b8c8e0'],
                                        'NEUTRAL' => ['label' => 'Neutral', 'desc' => 'Trung tính',           'color' => '#d4c5b5'],
                                    ];
                                @endphp
                                @foreach($undertones as $val => $info)
                                    <label class="tone-card {{ ($profile->undertone ?? '') == $val ? 'selected' : '' }}">
                                        <input type="radio" name="undertone" value="{{ $val }}"
                                            {{ ($profile->undertone ?? '') == $val ? 'checked' : '' }}>
                                        <span class="tone-dot" style="background:{{ $info['color'] }}"></span>
                                        <div>
                                            <span class="tone-name">{{ $info['label'] }}</span>
                                            <span class="tone-desc">{{ $info['desc'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Personal Color --}}
                        <div class="profile-group">
                            <h4 class="group-title">Personal Color (4 mùa)</h4>
                            <div class="color-season-options">
                                @php
                                    $seasons = [
                                        'SPRING_WARM'  => ['label' => 'Spring Warm',  'palette' => ['#f9c74f','#f4845f','#f9e4b7','#ffb347'], 'desc' => 'Tươi sáng, ấm áp'],
                                        'SUMMER_COOL'  => ['label' => 'Summer Cool',  'palette' => ['#a8c5da','#c9b1d0','#e8d5e3','#b5cce0'], 'desc' => 'Dịu nhẹ, thanh mát'],
                                        'AUTUMN_WARM'  => ['label' => 'Autumn Warm',  'palette' => ['#c0602a','#8b5e3c','#d4a55a','#7a4f35'], 'desc' => 'Đất, ấm, trầm'],
                                        'WINTER_COOL'  => ['label' => 'Winter Cool',  'palette' => ['#2c3e6b','#1a1a2e','#c0392b','#f0f0f5'], 'desc' => 'Tương phản, lạnh, sắc nét'],
                                    ];
                                @endphp
                                @foreach($seasons as $val => $info)
                                    <label class="season-card {{ ($profile->personal_color ?? '') == $val ? 'selected' : '' }}">
                                        <input type="radio" name="personal_color" value="{{ $val }}"
                                            {{ ($profile->personal_color ?? '') == $val ? 'checked' : '' }}>
                                        <div class="season-palette">
                                            @foreach($info['palette'] as $c)
                                                <span style="background:{{ $c }}"></span>
                                            @endforeach
                                        </div>
                                        <span class="season-name">{{ $info['label'] }}</span>
                                        <span class="season-desc">{{ $info['desc'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Favorite styles --}}
                        <div class="profile-group">
                            <h4 class="group-title">Style yêu thích <span class="optional-tag">Tuỳ chọn</span></h4>
                            @php
                                $allStyles = ['Minimalist','Classic','Streetwear','Bohemian','Sporty','Casual','Elegant','Vintage','Preppy','Edgy'];
                                $favStyles = json_decode($profile->favorite_styles ?? '[]', true) ?? [];
                            @endphp
                            <div class="style-tags">
                                @foreach($allStyles as $style)
                                    <label class="style-tag {{ in_array($style, $favStyles) ? 'selected' : '' }}">
                                        <input type="checkbox" name="favorite_styles[]" value="{{ $style }}"
                                            {{ in_array($style, $favStyles) ? 'checked' : '' }}>
                                        {{ $style }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">Lưu thay đổi</button>
                        </div>
                    </div>

                    {{-- RIGHT: Portrait --}}
                    <div class="portrait-section">
                        <h4 class="group-title">Ảnh chân dung</h4>
                        <div class="portrait-frame">
                            <img id="portraitPreview"
                                src="{{ !empty($profile->portrait_image) ? Storage::url($profile->portrait_image) : 'https://ps.w.org/user-avatar-reloaded/assets/icon-256x256.png?rev=2540745' }}"
                                alt="portrait">
                        </div>
                        <label for="portraitUpload" class="btn-choose-img">Chọn Ảnh</label>
                        <input type="file" id="portraitUpload" name="portrait_image" accept="image/*" style="display:none">
                        <p class="avatar-hint">Ảnh chân dung giúp gợi ý<br>màu sắc phù hợp hơn<br><br>Tối đa 2 MB · JPEG, PNG</p>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<style>
/* Reuse account-page styles from account.blade.php */
* { box-sizing: border-box; }

.account-page {
    display: flex;
    min-height: 100vh;
    background: #faf8f6;
    font-family: 'Be Vietnam Pro', sans-serif;
}

.account-main {
    flex: 1;
    padding: 40px 48px;
}

.section-header h2 {
    font-size: 22px;
    font-weight: 700;
    color: #2d2420;
    margin: 0 0 4px;
}
.section-header p { font-size: 13px; color: #9b8b82; margin: 0; }
.section-divider { height: 1px; background: #ede8e4; margin: 20px 0 32px; }

.alert-msg { padding: 10px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 20px; }
.alert-err { background: #fdecea; color: #c0392b; border: 1px solid #f5c6c0; }
.alert-ok  { background: #edfaf1; color: #1e8449; border: 1px solid #a9dfbf; }

/* ===== PROFILE LAYOUT ===== */
.profile-form-layout {
    display: flex;
    gap: 48px;
    align-items: flex-start;
}

.profile-fields { flex: 1; max-width: 640px; }

.profile-group {
    margin-bottom: 36px;
}

.group-title {
    font-size: 14px;
    font-weight: 700;
    color: #2d2420;
    margin: 0 0 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.optional-tag {
    font-size: 10.5px;
    font-weight: 500;
    color: #9b8b82;
    background: #f0ece8;
    padding: 2px 8px;
    border-radius: 20px;
}

.fields-row-2 {
    display: flex;
    gap: 20px;
}

.field-col {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.field-col label {
    font-size: 13px;
    color: #5a4a42;
    font-weight: 500;
}

.field-input {
    padding: 9px 13px;
    border: 1px solid #e0d8d2;
    border-radius: 6px;
    font-size: 13.5px;
    font-family: 'Be Vietnam Pro', sans-serif;
    color: #2d2420;
    background: #fff;
    outline: none;
    transition: border-color .15s;
    width: 100%;
}
.field-input:focus { border-color: #c0392b; box-shadow: 0 0 0 3px rgba(192,57,43,.08); }

/* Body Shape */
.shape-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.shape-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 12px 16px;
    border: 1.5px solid #e0d8d2;
    border-radius: 10px;
    cursor: pointer;
    background: #fff;
    transition: all .15s;
    min-width: 90px;
}

.shape-card input { display: none; }

.shape-card:hover { border-color: #c0392b; background: #fff9f8; }

.shape-card.selected {
    border-color: #c0392b;
    background: #fdf0ec;
}

.shape-icon { font-size: 22px; }
.shape-label { font-size: 12px; color: #5a4a42; font-weight: 500; text-align: center; }

/* Undertone */
.tone-options {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.tone-card {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 16px;
    border: 1.5px solid #e0d8d2;
    border-radius: 10px;
    cursor: pointer;
    background: #fff;
    transition: all .15s;
    min-width: 150px;
}

.tone-card input { display: none; }
.tone-card:hover { border-color: #c0392b; background: #fff9f8; }
.tone-card.selected { border-color: #c0392b; background: #fdf0ec; }

.tone-dot {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    flex-shrink: 0;
    border: 2px solid rgba(0,0,0,.08);
}

.tone-name { display: block; font-size: 13.5px; font-weight: 600; color: #2d2420; }
.tone-desc { display: block; font-size: 11.5px; color: #9b8b82; }

/* Season Cards */
.color-season-options {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.season-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 7px;
    padding: 14px 14px 12px;
    border: 1.5px solid #e0d8d2;
    border-radius: 10px;
    cursor: pointer;
    background: #fff;
    transition: all .15s;
    min-width: 130px;
}

.season-card input { display: none; }
.season-card:hover { border-color: #c0392b; background: #fff9f8; }
.season-card.selected { border-color: #c0392b; background: #fdf0ec; }

.season-palette {
    display: flex;
    border-radius: 20px;
    overflow: hidden;
    width: 72px;
    height: 20px;
    flex-shrink: 0;
}

.season-palette span {
    flex: 1;
    display: block;
}

.season-name {
    font-size: 12.5px;
    font-weight: 700;
    color: #2d2420;
    text-align: center;
}

.season-desc {
    font-size: 11px;
    color: #9b8b82;
    text-align: center;
}

/* Style Tags */
.style-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.style-tag {
    padding: 7px 16px;
    border: 1.5px solid #e0d8d2;
    border-radius: 20px;
    font-size: 13px;
    color: #5a4a42;
    cursor: pointer;
    background: #fff;
    font-family: 'Be Vietnam Pro', sans-serif;
    transition: all .15s;
}

.style-tag input { display: none; }
.style-tag:hover { border-color: #c0392b; color: #c0392b; background: #fff9f8; }
.style-tag.selected { border-color: #c0392b; background: #c0392b; color: #fff; }

/* Portrait section */
.portrait-section {
    width: 180px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding-top: 4px;
}

.portrait-frame {
    width: 150px;
    height: 190px;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #e8d5c4;
}

.portrait-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.btn-choose-img {
    border: 1px solid #ccc;
    padding: 8px 22px;
    border-radius: 6px;
    font-size: 13px;
    font-family: 'Be Vietnam Pro', sans-serif;
    color: #2d2420;
    cursor: pointer;
    background: #fff;
    transition: border-color .15s;
    text-align: center;
    display: inline-block;
}
.btn-choose-img:hover { border-color: #c0392b; color: #c0392b; }

.avatar-hint {
    font-size: 11.5px;
    color: #b0a49c;
    text-align: center;
    line-height: 1.7;
    margin: 0;
}

/* Save */
.form-actions { margin-top: 32px; }
.btn-save {
    background: #c0392b;
    color: #fff;
    border: none;
    padding: 10px 36px;
    border-radius: 6px;
    font-size: 14px;
    font-family: 'Be Vietnam Pro', sans-serif;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
}
.btn-save:hover { background: #a93226; }
</style>

<script>
// Toggle selected class on card clicks
document.querySelectorAll('.shape-card, .tone-card, .season-card').forEach(card => {
    card.querySelector('input').addEventListener('change', function() {
        const name = this.name;
        document.querySelectorAll(`input[name="${name}"]`).forEach(inp => {
            inp.closest('label').classList.remove('selected');
        });
        this.closest('label').classList.add('selected');
    });
});

document.querySelectorAll('.style-tag input').forEach(cb => {
    cb.addEventListener('change', function() {
        this.closest('label').classList.toggle('selected', this.checked);
    });
});

// Portrait preview
document.getElementById('portraitUpload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('portraitPreview').src = e.target.result;
        reader.readAsDataURL(file);
    }
});
</script>

@stop