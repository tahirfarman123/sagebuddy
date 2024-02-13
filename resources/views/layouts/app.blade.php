@php
$sidebar_key = Auth::user()->getSidebarKey();
$show_sidebar = Session::get($sidebar_key);
@endphp
<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body class="hold-transition sidebar-mini layout-fixed pr-0">
    <div id="preloader" class="preloader flex-column justify-content-center align-items-center">
        <img id="preloader-img" class="animation__shake" src="{{ asset('dist/img/sf.gif')}}" alt="AdminLTELogo"
            height="60" width="60">
    </div>
    {{-- @include('layouts.header') --}}
    <!-- ======= Sidebar ======= -->
    @role('SuperAdmin')
    @include('superadmin.aside')
    @endrole
    @role('Admin|SubUser')
    {{-- @if($show_sidebar) --}}
    @include('layouts.topbar')
    @include('layouts.aside')
    {{-- @endif --}}
    @endrole
    @if(Auth::check())
    <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
    @endif
    {{-- <main id="main" class="main">
        @if(Auth::check())
        <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
        @endif
        @include('layouts.success_message')
        <!-- End Sidebar-->
        @yield('content')
    </main> --}}
    <div class="content-wrapper p-3">
        <div>
            @include('layouts.success_message')
        </div>
        @yield('content')
    </div>
    @include('layouts.footer')
    @include('layouts.scripts')
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/dist/js/adminlte.js') }}"></script>
    {{-- <script src="{{ asset('/dist/js/pages/dashboard.js') }}"></script> --}}
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('.select2').select2()
    </script>
    @yield('scripts')
    {{-- @if(!$show_sidebar) --}}
    {{-- <script>
        $(document).ready(function () {
            $('.toggle-sidebar-btn').click();
        })
    </script> --}}
    {{-- @endif --}}

    <input type="hidden" id="currentRoutePath" value="{{ url()->current() }}">
    <script>
        function changeStore(name){
            $.ajax({
                type: 'GET',
                url: "{{ url('select/store') }}/" + name,
                // async: false,
                success: function (response) {
                    var currentRoutePath = $('#currentRoutePath').val();
                    window.location.href = currentRoutePath;
                }
            });
        }
        
    </script>
</body>

</html>