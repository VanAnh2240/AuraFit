{{-- resources/views/layout/sidebar.blade.php --}}
<aside class="account-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-avatar">
            <img src="{{ !empty(Auth::user()->AVATAR)
                ? Storage::url(Auth::user()->AVATAR)
                : 'https://ps.w.org/user-avatar-reloaded/assets/icon-256x256.png?rev=2540745' }}"
                alt="avatar">
        </div>
        <div class="sidebar-user-info">
            <span class="sidebar-username">{{ Auth::user()->USERNAME }}</span>
            <a href="{{ route('account') }}" class="sidebar-edit-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Sửa hồ sơ
            </a>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-nav-group">
            <span class="sidebar-nav-label">Tài khoản của tôi</span>
            <ul>
                <li class="@if(Route::currentRouteName() === 'profile') active @endif">
                    <a href="{{ route('account') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        Thông tin tài khoản
                    </a>
                </li>
                <li class="@if(Route::currentRouteName() === 'account.profile') active @endif">
                    <a href="{{ route('account.profile') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2a5 5 0 1 0 0 10A5 5 0 0 0 12 2z"/><path d="M9 13h6l1 3H8l1-3z"/><rect x="3" y="18" width="18" height="4" rx="2"/></svg>
                        Thông tin cá nhân
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-nav-group">
            <span class="sidebar-nav-label">Đơn hàng</span>
            <ul>
                <li class="@if(str_contains(Route::currentRouteName() ?? '', 'orders')) active @endif">
                    <a href="{{ route('customer.orders') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        Quản lý đơn hàng
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>

<style>
.account-sidebar {
    width: 230px;
    min-width: 230px;
    background: #fff;
    border-right: 1px solid #f0ece8;
    min-height: 100vh;
    padding: 32px 0 24px;
    font-family: 'Be Vietnam Pro', 'Roboto', sans-serif;
}

.sidebar-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 20px 24px;
    border-bottom: 1px solid #f0ece8;
    margin-bottom: 20px;
}

.sidebar-avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #e8d5c4;
    flex-shrink: 0;
}

.sidebar-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.sidebar-user-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 0;
}

.sidebar-username {
    font-size: 13.5px;
    font-weight: 600;
    color: #2d2420;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.sidebar-edit-link {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: #9b6b4a;
    text-decoration: none;
    transition: color .15s;
}
.sidebar-edit-link:hover { color: #c0392b; }

.sidebar-nav-group { margin-bottom: 4px; }

.sidebar-nav-label {
    display: block;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #bbb0a8;
    padding: 8px 20px 4px;
}

.sidebar-nav ul { list-style: none; margin: 0; padding: 0; }

.sidebar-nav li a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 20px;
    font-size: 13.5px;
    color: #5a4a42;
    text-decoration: none;
    border-left: 3px solid transparent;
    transition: all .15s;
}

.sidebar-nav li a:hover {
    color: #c0392b;
    background: #fdf6f3;
    border-left-color: #e8c5b8;
}

.sidebar-nav li.active a {
    color: #c0392b;
    background: #fdf0ec;
    border-left-color: #c0392b;
    font-weight: 600;
}

.sidebar-nav li a svg { flex-shrink: 0; opacity: .75; }
.sidebar-nav li.active a svg,
.sidebar-nav li a:hover svg { opacity: 1; }
</style>