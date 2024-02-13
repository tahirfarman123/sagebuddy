@php $isEmbedded = determineIfAppIsEmbedded() @endphp
<aside class="main-sidebar bg-white pb-5" @if($isEmbedded) style="background-color:#f1f2f4" @endif>

  <a href="{{route('home')}}" class="brand-link pt-4 px-3 text-decoration-none">
    <img src="{{ asset('dist/img/icon.png')}}" alt={props.alttext} class="brand-image " />
    <span class="brand-text font-weight-bold">Shop Flow</span>
  </a>
  <br>


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
        @if (auth()->user()->roles[0]->name == 'Admin')
        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="{{ route('admin.stores.index') }}" class="nav-link">
            <i class="nav-icon uil uil-apps"></i>
            <p class='ml-2'>
              Stores
            </p>
          </a>

        </li>
        @endif

        <li class="nav-item rightborder" id='content-wrapper'>
          <a class="nav-link">
            <i class="nav-icon uil uil-shopping-cart-alt"></i>
            <p class='ml-2'>
              Sales
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @canany(['all-access','write-orders','read-orders'])
            <li class="nav-item ">
              <a href="{{route('shopify.orders')}}" class="nav-link">
                <i class="nav-icon uil uil-database"></i>
                <p class='ml-2'>Order</p>
              </a>
            </li>
            @endcanany
            @canany(['all-access','write-customers','read-customers'])

            <li class="nav-item ">
              <a href="{{route('shopify.customers')}}" class="nav-link">
                <i class="nav-icon uil uil-user"></i>
                <p class='ml-2'>Customers</p>
              </a>
            </li>
            @endcanany
          </ul>
        </li>
        @if (auth()->user()->roles[0]->name == 'Admin')
        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="{{ route('admin.users.index') }}" class="nav-link">
            <i class="nav-icon uil uil-user"></i>
            <p class='ml-2'>
              Users
            </p>
          </a>

        </li>
        @endif
        {{-- <li class="nav-item rightborder" id='content-wrapper'>
          <a class="nav-link">
            <i class="nav-icon uil uil-check-square"></i>
            <p class='ml-2'>
              Purchasing
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item ">
              <a href="/Purchases" class="nav-link">
                <i class="nav-icon uil uil-shopping-cart-alt"></i>

                <p class='ml-2'>Purchases</p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="/Suppliers" class="nav-link">
                <i class="nav-icon uil uil-user"></i>
                <p class='ml-2'>Suppliers</p>
              </a>
            </li>
          </ul>
        </li> --}}
        @canany(['all-access','write-products','read-products'])
        {{-- <li class="nav-item rightborder" id='content-wrapper'>
          <a class="nav-link">
            <i class="nav-icon uil uil-database"></i>
            <p class='ml-2'>
              Inventory
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item ">
              <a href="{{ route('shopify.products')}}" class="nav-link">
                <i class="nav-icon uil uil-box"></i>
                <p class='ml-2'>Products</p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="/StockTransfer" class="nav-link">
                <i class="nav-icon uil uil-luggage-cart"></i>
                <p class='ml-2'>Stock Transfer</p>
              </a>
            </li>
          </ul>
        </li> --}}
        @endcanany
        {{-- <li class="nav-item rightborder" id='content-wrapper'>
          <a class="nav-link">
            <i class="nav-icon uil uil-usd-square"></i>
            <p class='ml-2'>
              Financials
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item ">
              <a href="/ChartOfAccount" class="nav-link">
                <i class="nav-icon uil uil-chart"></i>
                <p class='ml-2'>Chart Of Account</p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="/Expense" class="nav-link">
                <i class="nav-icon uil uil-bill"></i>
                <p class='ml-2'>Expense</p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="/SupplierLedger" class="nav-link">
                <i class="nav-icon uil uil-user"></i>
                <p class='ml-2'>Supplier Ledger</p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="/CustomerLedger" class="nav-link">
                <i class="nav-icon uil uil-user"></i>
                <p class='ml-2'>Customer Ledger</p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="/CreditNotes" class="nav-link">
                <i class="nav-icon uil uil-notes"></i>
                <p class='ml-2'>Credit Notes</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="/Automation" class="nav-link">
            <i class="nav-icon uil uil-brightness"></i>
            <p class='ml-2'>
              Automation
            </p>
          </a>

        </li>
        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="/Reports" class="nav-link">
            <i class="nav-icon uil uil-file-medical-alt"></i>
            <p class='ml-2'>
              Reports
            </p>
          </a>

        </li>
        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="/Import" class="nav-link">
            <i class="nav-icon uil uil-file-import"></i>
            <p class='ml-2'>
              Import
            </p>
          </a>

        </li>
        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="/Export" class="nav-link">
            <i class="nav-icon uil uil-file-export"></i>
            <p class='ml-2'>
              Export
            </p>
          </a>

        </li>--}}
        @canany(['all-access','write-setting'])
        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="{{ route('settings')}}" class="nav-link">
            <i class="nav-icon uil uil-setting"></i>
            <p class='ml-2'>
              Setting
            </p>
          </a>

        </li>
        @endcanany
        <li class="nav-item rightborder" id='content-wrapper'>
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-user').submit();"
            class="nav-link">
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