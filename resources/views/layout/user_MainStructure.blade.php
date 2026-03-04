<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>@yield('title', 'Tiêu đề mặc định')</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/default-font.css') }}">
    <link rel="stylesheet" href="{{asset('frontend/css/user_MainStructure.css')}}">

    <style>
        *{
            font-family: 'Be Vietnam Pro', sans-serif;
        }
    </style>

</head>
<body >
@include ('layout.header')
<main>
    @yield('content')
    <!--=============== SCROLL UP ===============-->
    <a href="#" class="scrollup shadow" id="scroll-up">
        <i class='bx bx-up-arrow-alt scrollup__icon'></i>
    </a>
    <style>
        /*=============== SCROLL UP ===============*/
        .scrollup{
            position: fixed;
            background: var(--main-color-light);
            right: 1rem;
            bottom: -20%;
            display: inline-flex;
            padding: .3rem;
            border-radius: .25rem;
            z-index: var(--z-tooltip);
            opacity: .8;
            transition: .4s;
        }
        
        .scrollup__icon{
            font-size: 1.25rem;
            color: var(--white-color);
        }
        
        .scrollup:hover{
            background: var(--main-color-lighter);
            opacity: 1;
        }
        
        /* Show Scroll Up*/
        .show-scroll{
            bottom: 3rem;
        }
    </style>
    <script>
        /*=============== SHOW SCROLL UP ===============*/
        let body = document.body;
        function scrollUp(){
        const scrollUp = document.getElementById('scroll-up');
        if(this.scrollY >= 460) scrollUp.classList.add('show-scroll');
        else scrollUp.classList.remove('show-scroll')
        }
        window.addEventListener('scroll', scrollUp);
    </script>
</main>
@include ('layout.footer')
</body>
</html>
