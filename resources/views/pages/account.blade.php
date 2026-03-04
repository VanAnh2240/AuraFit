{{-- resources/views/pages/account.blade.php --}}
@extends('layout.layout')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="account-page">
    @include('layout.sidebar')

    <main class="account-main">
        <div class="account-section">
            <div class="section-header">
                <h2>Hồ Sơ Của Tôi</h2>
                <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            </div>
            <div class="section-divider"></div>

            <form action="/profile/update/{{ $user->CUSTOMER_ID }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="account-form-layout">
                    <div class="form-fields">

                        @if(session('error'))
                            <div class="alert-msg alert-err">{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                            <div class="alert-msg alert-ok">{{ session('success') }}</div>
                        @endif

                        <div class="field-row">
                            <label>Tên đăng nhập</label>
                            <div class="readonly-val">{{ $user->USERNAME }}</div>
                        </div>

                        <div class="field-row">
                            <label>Họ và tên</label>
                            <input type="text" name="fullName"
                                value="{{ trim(($user->LAST_NAME ?? '') . ' ' . ($user->FIRST_NAME ?? '')) }}"
                                class="field-input">
                        </div>

                        <div class="field-row">
                            <label>Email</label>
                            <span class="info-val">{{ $user->EMAIL ?: '---' }}</span>
                            <button type="button" class="link-btn" data-bs-toggle="modal" data-bs-target="#modalemail">Thay Đổi</button>
                        </div>

                        <div class="field-row">
                            <label>Số điện thoại</label>
                            <span class="info-val">{{ $user->PHONE_NUMBER ?: '---' }}</span>
                            <button type="button" class="link-btn" data-bs-toggle="modal" data-bs-target="#modalphone">Thay Đổi</button>
                        </div>

                        <div class="field-row">
                            <label>Ngày sinh</label>
                            <span class="info-val">
                                {{ !empty($user->birthday) ? \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') : '---' }}
                            </span>
                            <button type="button" class="link-btn" data-bs-toggle="modal" data-bs-target="#modalbirth">Thay Đổi</button>
                        </div>

                        {{-- Địa chỉ: 2 cấp Province → Ward --}}
                        <div class="field-row field-row--full">
                            <label>Tỉnh / Thành phố</label>
                            <select name="province_code" id="provinceSelect" class="field-input">
                                <option value="">-- Chọn tỉnh/thành --</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->code }}"
                                        {{ ($user->province_code ?? '') == $province->code ? 'selected' : '' }}>
                                        {{ $province->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field-row field-row--full">
                            <label>Phường / Xã</label>
                            <select name="ward_code" id="wardSelect" class="field-input">
                                <option value="">-- Chọn phường/xã --</option>
                                @foreach($wards as $ward)
                                    <option value="{{ $ward->code }}"
                                        {{ ($user->ward_code ?? '') == $ward->code ? 'selected' : '' }}>
                                        {{ $ward->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field-row field-row--full">
                            <label>Địa chỉ cụ thể</label>
                            <input type="text" name="address_detail" class="field-input"
                                placeholder="Số nhà, tên đường..."
                                value="{{ $user->address_detail ?? '' }}">
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">Lưu</button>
                        </div>
                    </div>

                    {{-- Avatar --}}
                    <div class="avatar-section">
                        <div class="avatar-circle" onclick="document.getElementById('avatarUpload').click()" style="cursor:pointer;" title="Nhấn để đổi ảnh">
                            <img id="avatarPreview"
                                src="{{ !empty($user->AVATAR) ? Storage::url($user->AVATAR) : 'https://ps.w.org/user-avatar-reloaded/assets/icon-256x256.png?rev=2540745' }}"
                                alt="avatar">
                        </div>
                        <button type="button" class="btn-choose-img" onclick="document.getElementById('avatarUpload').click()">Chọn Ảnh</button>
                        <input type="file" id="avatarUpload" name="avatar" accept="image/jpeg,image/png,image/jpg" style="display:none">
                        <p class="avatar-hint">Dung lượng file tối đa 1 MB<br>Định dạng: .JPEG, .PNG</p>
                        <p id="avatarFileName" style="font-size:11.5px;color:#c0392b;margin:0;display:none;"></p>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

{{-- Modal: Email --}}
<div class="modal fade" id="modalemail" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/profile/update/{{ $user->CUSTOMER_ID }}" method="POST">
            @csrf
            <div class="modal-content account-modal">
                <div class="modal-header"><h5>Cập nhật Email</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body"><input type="email" name="email" class="field-input w-100" placeholder="Email mới" value="{{ $user->EMAIL }}"></div>
                <div class="modal-footer"><button type="button" class="btn-cancel" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn-save">Lưu</button></div>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Phone --}}
<div class="modal fade" id="modalphone" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/profile/update/{{ $user->CUSTOMER_ID }}" method="POST">
            @csrf
            <div class="modal-content account-modal">
                <div class="modal-header"><h5>Cập nhật Số điện thoại</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body"><input type="text" name="phone" class="field-input w-100" placeholder="Số điện thoại" value="{{ $user->PHONE_NUMBER }}"></div>
                <div class="modal-footer"><button type="button" class="btn-cancel" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn-save">Lưu</button></div>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Birthday --}}
<div class="modal fade" id="modalbirth" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/profile/update/{{ $user->CUSTOMER_ID }}" method="POST">
            @csrf
            <div class="modal-content account-modal">
                <div class="modal-header"><h5>Cập nhật Ngày sinh</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body"><input type="date" name="birthday" class="field-input w-100" value="{{ $user->birthday ?? '' }}"></div>
                <div class="modal-footer"><button type="button" class="btn-cancel" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn-save">Lưu</button></div>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Password --}}
<div class="modal fade" id="modalpass" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/profile/update_pass/{{ $user->CUSTOMER_ID }}" method="POST">
            @csrf
            <div class="modal-content account-modal">
                <div class="modal-header"><h5>Đổi mật khẩu</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <input type="password" name="old_pass" class="field-input w-100 mb-2" placeholder="Mật khẩu cũ">
                    <input type="password" name="new_pass" class="field-input w-100 mb-2" placeholder="Mật khẩu mới">
                    <input type="password" name="cf_new_pass" class="field-input w-100" placeholder="Xác nhận mật khẩu mới">
                </div>
                <div class="modal-footer"><button type="button" class="btn-cancel" data-bs-dismiss="modal">Đóng</button><button type="submit" class="btn-save">Lưu</button></div>
            </div>
        </form>
    </div>
</div>

<style>
* { box-sizing: border-box; }
.account-page { display: flex; min-height: 100vh; background: #faf8f6; font-family: 'Be Vietnam Pro', sans-serif; }
.account-main { flex: 1; padding: 40px 48px; max-width: 800px; }
.section-header h2 { font-size: 22px; font-weight: 700; color: #2d2420; margin: 0 0 4px; }
.section-header p { font-size: 13px; color: #9b8b82; margin: 0; }
.section-divider { height: 1px; background: #ede8e4; margin: 20px 0 32px; }
.account-form-layout { display: flex; gap: 60px; }
.form-fields { flex: 1; }
.field-row { display: flex; align-items: center; margin-bottom: 20px; gap: 16px; }
.field-row label { width: 140px; min-width: 140px; font-size: 13.5px; color: #5a4a42; font-weight: 500; }
.field-row--full { flex-direction: column; align-items: flex-start; }
.field-row--full label { width: auto; margin-bottom: 6px; }
.field-row--full .field-input { width: 100%; max-width: 420px; }
.info-val { font-size: 13.5px; color: #2d2420; flex: 1; }
.readonly-val { font-size: 14px; color: #2d2420; font-weight: 500; }
.field-input { flex: 1; max-width: 280px; padding: 9px 13px; border: 1px solid #e0d8d2; border-radius: 6px; font-size: 13.5px; font-family: 'Be Vietnam Pro', sans-serif; color: #2d2420; background: #fff; transition: border-color .15s; outline: none; }
.field-input:focus { border-color: #c0392b; box-shadow: 0 0 0 3px rgba(192,57,43,.08); }
.field-input.w-100 { max-width: 100%; width: 100%; }
.link-btn { background: none; border: none; color: #c0392b; font-size: 13px; font-family: 'Be Vietnam Pro', sans-serif; cursor: pointer; padding: 0; text-decoration: underline; text-underline-offset: 2px; white-space: nowrap; }
.link-btn:hover { color: #922b21; }
.alert-msg { padding: 10px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 20px; }
.alert-err { background: #fdecea; color: #c0392b; border: 1px solid #f5c6c0; }
.alert-ok  { background: #edfaf1; color: #1e8449; border: 1px solid #a9dfbf; }
.form-actions { margin-top: 32px; }
.btn-save { background: #c0392b; color: #fff; border: none; padding: 10px 36px; border-radius: 6px; font-size: 14px; font-family: 'Be Vietnam Pro', sans-serif; font-weight: 600; cursor: pointer; transition: background .15s; }
.btn-save:hover { background: #a93226; }
.avatar-section { display: flex; flex-direction: column; align-items: center; gap: 14px; padding-top: 8px; }
.avatar-circle { width: 120px; height: 120px; border-radius: 50%; overflow: hidden; border: 3px solid #e8d5c4; }
.avatar-circle img { width: 100%; height: 100%; object-fit: cover; }
.btn-choose-img { border: 1px solid #ccc; padding: 8px 22px; border-radius: 6px; font-size: 13px; font-family: 'Be Vietnam Pro', sans-serif; color: #2d2420; cursor: pointer; background: #fff; transition: border-color .15s; }
.btn-choose-img:hover { border-color: #c0392b; color: #c0392b; }
.avatar-hint { font-size: 11.5px; color: #b0a49c; text-align: center; line-height: 1.6; margin: 0; }
.account-modal .modal-header { border-bottom: 1px solid #f0ece8; padding: 16px 20px; }
.account-modal .modal-header h5 { font-family: 'Be Vietnam Pro', sans-serif; font-size: 15px; font-weight: 600; color: #2d2420; margin: 0; }
.account-modal .modal-body { padding: 20px; }
.account-modal .modal-footer { border-top: 1px solid #f0ece8; padding: 12px 20px; gap: 8px; }
.btn-cancel { background: none; border: 1px solid #ddd; padding: 8px 20px; border-radius: 6px; font-size: 13.5px; font-family: 'Be Vietnam Pro', sans-serif; color: #666; cursor: pointer; }
.btn-cancel:hover { background: #f5f5f5; }
.mb-2 { margin-bottom: 10px !important; }
</style>

<script>
document.getElementById('avatarUpload').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;

    // Hiển thị tên file đã chọn
    const nameEl = document.getElementById('avatarFileName');
    nameEl.textContent = file.name;
    nameEl.style.display = 'block';

    // Preview ảnh
    const reader = new FileReader();
    reader.onload = function(evt) {
        document.getElementById('avatarPreview').src = evt.target.result;
    };
    reader.readAsDataURL(file);
});

const selectedWard = "{{ $user->ward_code ?? '' }}";

function loadWards(provinceCode, wardVal) {
    const wardSelect = document.getElementById('wardSelect');
    wardSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
    if (!provinceCode) {
        wardSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
        return;
    }
    fetch(`/api/wards?province_code=${provinceCode}`)
        .then(r => r.json())
        .then(data => {
            wardSelect.innerHTML = '<option value="">-- Chọn phường/xã --</option>';
            data.forEach(w => {
                const opt = document.createElement('option');
                opt.value = w.code;
                opt.textContent = w.full_name;
                if (w.code == wardVal) opt.selected = true;
                wardSelect.appendChild(opt);
            });
        })
        .catch(() => {
            wardSelect.innerHTML = '<option value="">-- Lỗi tải dữ liệu --</option>';
        });
}

document.getElementById('provinceSelect').addEventListener('change', function() {
    loadWards(this.value, null);
});

const initProvince = document.getElementById('provinceSelect').value;
if (initProvince) loadWards(initProvince, selectedWard);
</script>

@stop