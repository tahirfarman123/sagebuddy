<div id="box-floating" style="display: none; background: #fff;
padding: 13px;
position: fixed;
bottom: 30px;
left: 40%;
box-shadow: 0px 2px 10px 5px #bdbaba;
border-radius: 10px;
">
    <div>
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#book-fullfill-order">Book For
            Delivery</button>
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#mark-fullfillment">Mark As
            FullFillment</button>
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#capture-payment">Capture
            Payment</button>
        {{-- <button class="btn btn-outline-primary">...</button> --}}
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-icon" data-toggle="dropdown"
                aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu" style="">
                <a class="dropdown-item cancel-order" href="#" data-toggle="modal" data-target="#packing-order">Print
                    Packing List</a>
                <a class="dropdown-item cancel-order" href="#" data-toggle="modal" data-target="#cancel-order">Cacnel
                    Order</a>
                <a class="dropdown-item cancel-void" href="#" data-toggle="modal" data-target="#cancel-order">Voided
                    Delivery</a>
                <a class="dropdown-item" href="#">Update</a>
                <a class="dropdown-item" href="#">Canel</a>
            </div>
        </div>
    </div>
</div>