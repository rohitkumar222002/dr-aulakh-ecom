

<!-- ========== Left Sidebar Start ========== -->
<div class="sidebar-left">

    <div data-simplebar class="h-100">

        <!--- Sidebar-menu -->
        <div id="sidebar-menu">

            <div class="card-body pt-0">
                <div class="row align-items-end">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <div class="avatar-md mb-1">
                            <img src="{{ auth()->user()->avatar ? uploaded_asset(auth()->user()->avatar) : asset('panel/images/users/avatar-1.png') }}"
                                class="img-fluid avatar-circle bg-light p-2 border-2 border-primary ml-20">
                        </div>
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
            </div>
            <ul class="left-menu list-unstyled" id="side-menu">
<li>
                    <a href="{{ route('user.dashboard') }}">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>

                </li>
                <li>
                    <a href="{{ route('user.profile') }}">
                        <i class="fa fa-shapes"></i>
                        <span>Profile</span>
                    </a>

                </li>
                 <li>
                    <a href="{{ route('user.product') }}">
                        <i class="fa fa-box"></i>
                        <span>Products</span>
                    </a>

                </li>
                <li>
                    <a href="{{ route('user.cart.index') }}">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Cart</span>
                    </a>

                </li>
                 <li>
                    <a href="{{ route('user.orders') }}">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Orders</span>
                    </a>

                </li> 
                <li>
                    <a href="{{ route('user.direct.referrals') }}">
                        <i class="fa fa-users"></i>
                        <span>My Referrals</span>
                    </a>

                </li>
               
<li>
                    <a href="{{ route('user.downline') }}">
                        <i class="fa fa-wallet"></i>
                        <span>My Affiliate Profit</span>
                    </a>

                </li>
                  <li>
                    <a href="{{ route('user.transactions') }}">
                        <i class="fa fa-receipt"></i>
                        <span>Transaction</span>
                    </a>

                </li>
                <li>
                    <a href="{{ route('logout') }}" class="">
                        <i class="fas fa-desktop"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
