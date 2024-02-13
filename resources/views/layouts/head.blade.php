<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{config('app.name')}}</title>
    <!-- Favicons -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    @yield('css')
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="{{asset('assets/img/favicon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('assets/img/favicon.png')}}" rel="apple-touch-icon">
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon.ico')}}">
    <!-- Google Fonts -->
    <!-- Vendor CSS Files -->


    {{--
    <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"> --}}
    {{--
    <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet"> --}}
    {{--
    <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet"> --}}

    {{--
    <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet"> --}}

    {{--
    <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet"> --}}
    {{--
    <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet"> --}}
    {{--
    <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet"> --}}
    <!-- Template Main CSS File -->


    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <!-- Theme style -->

    <link rel="stylesheet" href="{{ asset('/assets1/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
    {{--
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'> --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="{{ asset('/plugins/select2/css/select2.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    {{--
    <link rel="stylesheet" href="{{ asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"> --}}

    <link rel="stylesheet" href="{{ asset('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Alpine Core -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

</head>