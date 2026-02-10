<div class="sidebar-left">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="left-menu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="">
                        <i class="fas fa-desktop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>



             

                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-user-cog"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.users') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>List of Users</a></li>

                    </ul>
                </li>
                
  <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-user-cog"></i>
                        <span>Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.categories.index') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i> Categories</a></li>
         <li><a href="{{ route('admin.subcategories.index') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i> Subcategories</a></li>
         <li><a href="{{ route('admin.products.index') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i> Products</a></li>
<li><a href="{{ route('admin.coupons.index') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i> Coupons</a></li>

                    </ul>
                </li>
              
                  <li>
                    <a href="{{ route('admin.orders') }}" class="">
                        <i class="far fa-image"></i>
                        <span>Orders</span>
                    </a>
                </li>
                  <li>
                    <a href="{{ route('admin.transactions') }}" class="">
                       <i class="fas fa-exchange-alt"></i> 
                        <span>Transaction </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.articles.index') }}" class="">
                        <i class="far fa-image"></i>
                        <span>Articles</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('admin/uploaded-files') }}" class="">
                        <i class="far fa-image"></i>
                        <span>Uploads</span>
                    </a>
                </li>


                <li>
               
            
                <li
                    class="{{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                        class="has-arrow {{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'mm-active' : '' }}">
                        <i class="fa fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.settings') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i> General
                            </a></li>
                        <li
                            class="{{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.custom-page-all') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle {{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'active' : '' }} "></i>
                                Custom Pages
                            </a>
                        </li>
<li><a href="{{ route('admin.levels.index') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i> Tier Plan
                            </a></li>
                        <li><a href="{{ route('admin.slider') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i> Slider
                            </a></li>

                    </ul>
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
