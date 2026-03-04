<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="{{ asset('/assets/css/styles.css') }}" rel="stylesheet">
    <title>@yield('title', 'AuraFit')</title>

    <style>
        body {
            background-color: #f5f5f5;
        }

        /* ===== MAIN CONTENT AREA ===== */
        .profile-main {
            flex: 1;
            padding: 24px 32px;
            min-height: calc(100vh - 70px);
            overflow-y: auto;
        }
    </style>
</head>

<body>
    {{-- HEADER --}}
    @include('layout.header')

    {{-- PAGE BODY --}}
    <div class="d-flex">

        {{-- MAIN CONTENT --}}
        <div class="profile-main">
            @yield('content')
        </div>
    </div>

    {{-- FOOTER --}}
    @include('layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    @yield('scripts')
</body>

</html>