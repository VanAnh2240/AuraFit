<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<link rel="stylesheet" href="{{ asset('css/default-font.css') }}">
<link rel="stylesheet" href="{{asset('frontend/css/footer.css')}}">
<footer class="footer container-fluid text-center text-lg-start">
    <div class="container p-4">
        <div class="row">
            <div class="outro col-lg-6 col-md-12 mb-4 mb-md-0">
                <a href="#" class = "footer_brand h1">AuraFit</a>
                <p>Tiệm May Tháng Bảy – mang đến dịch vụ may đo chuyên nghiệp, trang phục vừa vặn, chất lượng cao, cùng trải nghiệm tư vấn và thử đồ ảo tiện lợi.</p>
                <div class="icons footer_icons text-center fs-3">
                    <a href="{{url('https://www.facebook.com/khank.tran.3150')}}" class="btn-facebook mx-1">
                        <i class='bx bxl-facebook-circle'></i>
                    </a>
                    <a href="{{url('https://github.com/merzp23/Shopbee')}}" class="btn-github mx-1">
                        <i class='bx bxl-github'></i>
                    </a>
                    <a href="#" class="btn-figma mx-1">
                        <i class='bx bxl-figma'></i>
                    </a>
                </div>
            </div>
            <div class="contact col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5>Liên hệ</h5>

                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="https://www.google.com/maps/place/Tr%C6%B0%E1%BB%9Dng+%C4%90%E1%BA%A1i+h%E1%BB%8Dc+C%C3%B4ng+ngh%E1%BB%87+Th%C3%B4ng+tin+-+%C4%90HQG+TP.HCM/@10.8702229,106.8000212,17z/data=!4m10!1m2!2m1!1suit!3m6!1s0x317527587e9ad5bf:0xafa66f9c8be3c91!8m2!3d10.8700089!4d106.8030541!15sCgN1aXSSAQp1bml2ZXJzaXR54AEA!16s%2Fm%2F02qqlmm?hl=vi-VN&entry=ttu">
                            <i class='bx bxs-home'></i>
                            University of Information Technology
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class='bx bxs-phone'></i>
                            (+84) 8484 14 64646
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class='bx bxl-gmail'></i>
                            aurafit@gmail.com
                        </a>
                    </li>
                </ul>
            </div>
            <div class="links col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5>Links</h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="{{route('home')}}">Trang chủ</a>
                    </li>
                    <li>
                        <a href="#">Về chúng tôi</a>
                    </li>
                    <li>
                        <a href="{{route('shop.index')}}">Dịch vụ</a>
                    </li>
                    <li>
                        <a href="#">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class=" copyright p-2">
        © All Rights Reserved - 2025 - AuraFit
    </div>
</footer>
