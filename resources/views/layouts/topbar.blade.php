<nav class="main-header navbar px-3 navbar-expand navbar-white navbar-light position-sticky">



    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="/" role="button">
                <i class="uil uil-bars"></i>
            </a>
        </li>
    </ul>
    @php
    $user = auth()->user();
    if (auth()->user()->roles[0]->name == 'SubUser'){
    $store_spil = explode(",", $user->store_id);

    $stores1 = \App\Models\Store::whereIn('table_id', $store_spil)->get();
    } else {
    $stores1 = \App\Models\Store::where('user_id', $user->id)->get();
    }
    $selected_store = base64_decode(request()->cookie('selected_sto'));
    @endphp
    <ul class="navbar-nav ml-auto">
        <div class="btn-group" style="    height: 44px;
        margin-top: 5px;">
            <button type="button" class="btn border">
                {{ in_array($selected_store, $stores1->pluck('name')->toArray()) ?
                $selected_store : 'Select Store' }}
            </button>
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown"
                aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu" style="">
                @if (auth()->user()->roles[0]->name != 'SubUser')
                <a class="dropdown-item" onclick="changeStore('all')" href="#">All</a>
                @endif
                @foreach ($stores1 as $store)
                <a class="dropdown-item" onclick="changeStore('{{$store->name}}')" href="#">{{ $store->name
                    }}</a>
                @endforeach
            </div>
        </div>
        <div class="d-flex m-2">
            <img src="{{ asset('dist/img/icon.png')}}" alt={noimage} class="img-fluid" style="height: 35px" />
            <div class="px-3 align-self-center">
                <h6 class="mb-0 font-weight-bold" style="font-size: 16px">{{ auth()->user()->name }}</h6>
                <p class="mb-0 text-mute" style="font-size: 12px">{{ auth()->user()->roles[0]->name }}</p>
            </div>
            <div class="btn-group">
                <button type="button" style="border: none;
                background: transparent;
            " class="dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu" style="">
                    <a class="dropdown-item" href="{{ route('profile')}}">
                        Profile
                    </a>
                    <a class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-user').submit();" href="">
                        <form id="logout-user" action="{{ route('logout') }}" method="POST" class="d-none"
                            style="display: none">
                            @csrf
                        </form>
                        Logout
                    </a>
                </div>
            </div>
        </div>

    </ul>
</nav>