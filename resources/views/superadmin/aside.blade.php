<aside id="sidebar" class="main-sidebar bg-white pb-5">
  <a href="{{route('home')}}" class="brand-link pt-4 px-3 text-decoration-none">
    <img src="{{ asset('dist/img/icon.png')}}" alt={props.alttext} class="brand-image " />
    <span class="brand-text font-weight-bold">Shop Flow</span>
  </a>
  <div class="sidebar px-3">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <p class="navigater brand-text" style="text-decoration: none , color: #C7C7C7 , font-size: 14px ,
          padding: 12px 0px 0px 19px , font-family: var(--font-family-OpenSans-Bold)">Main menu</p>
        <li class=" nav-item rightborder">
          <a href="{{route('home')}}" class="nav-link">
            <i class="nav-icon uil uil-tachometer-fast-alt"></i>
            <p class='ml-2'>
              Dashboard
            </p>
          </a>

        </li>

        {{-- <li class="nav-item">
          <a class="nav-link" href="{{route('real.time.notifications')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path fill="currentColor"
                d="M19.056 2h-14a3.003 3.003 0 0 0-3 3v14a3.003 3.003 0 0 0 3 3h14a3.003 3.003 0 0 0 3-3V5a3.003 3.003 0 0 0-3-3m-14 2h14a1.001 1.001 0 0 1 1 1v8H17.59a1.997 1.997 0 0 0-1.664.89L14.52 16H9.59l-1.406-2.11A1.997 1.997 0 0 0 6.52 13H4.056V5a1.001 1.001 0 0 1 1-1m14 16h-14a1.001 1.001 0 0 1-1-1v-4H6.52l1.406 2.11A1.997 1.997 0 0 0 9.59 18h4.93a1.997 1.997 0 0 0 1.664-.89L17.59 15h2.465v4a1.001 1.001 0 0 1-1 1" />
            </svg>
            <p>Send Real-time Notifications</p>
          </a>
        </li> --}}

        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="{{route('stores.index')}}" class="nav-link">
            <i class="nav-icon uil uil-apps"></i>
            <p class='ml-2'>
              Stores

            </p>
          </a>
        </li>
        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="{{route('users.index')}}" class="nav-link">
            <i class="nav-icon uil uil-user"></i>
            <p class='ml-2'>
              Users
            </p>
          </a>
        </li>

        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="{{ route('settings')}}" class="nav-link">
            <i class="nav-icon uil uil-setting"></i>
            <p class='ml-2'>
              Setting
            </p>
          </a>

        </li>

        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="{{route('users.index')}}"
            onclick="event.preventDefault(); document.getElementById('logout-user').submit();" class="nav-link">
            <i class="nav-icon uil uil-lock"></i>
            <form id="logout-user" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none">
              @csrf
            </form>
            <p class='ml-2'>
              Sign Out
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>