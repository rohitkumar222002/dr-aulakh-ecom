 
  <div class="top-notice-bar">
        <div class="container">
            <span>{{ get_setting('nav_title') }}</span>
        </div>
    </div>
 <nav class="desktop-nav">
        <div class="nav-container">
            <div class="nav-main">
                <!-- Left Section: Logo + Navigation -->
                  @if (get_setting('web_logo'))
                        <img loading="lazy" title="Logo" role="img"  class="brand-logo" alt="Company Logo" 
                            src="{{ uploaded_asset(get_setting('web_logo')) }}" >
                    @else
                        {{ get_setting('company_name') }}
                    @endif
                <div class="logo-section">
                    
                    <ul class="nav-links">
                        <li class="nav-link-item">
                            <a  href="{{ route('site.index') }}" class="nav-link  {{ Route::is('site.index') ? 'active' : '' }}">Home</a>
                        </li>
                         <li class="nav-link-item">
                            <a  href="{{ route('site.products') }}" class="nav-link {{ request()->routeIs('site.products*') ? 'active' : '' }}">Products</a>
                        </li>
                       
                       <li class="nav-link-item dropdown position-relative">
    <a class="nav-link " 
       href="{{ route('contact-us') }}">
        Contact Us
    </a>

  

</li>
    <style>
        @media (min-width: 992px) {
        .nav-link-item.dropdown:hover > .dropdown-menu {
            display: block;
            margin-top: 0;
        }
    }

    </style>

                         
                        

                    </ul>
                </div>
                
                <!-- Right Section: Search + Icons -->
                <div class="nav-right">
                    <!-- <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-box" placeholder="Search health topics...">
                    </div> -->
                    
                    <div class="nav-icons">
                        
                    @if (Auth::guard('admin')->check() ||
                            Auth::guard('web')->check() )
                       <div class="dropdown">
                        <button class="icon-btn dropdown-toggle" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                            <i class="far fa-user"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">

                            @if (Auth::guard('admin')->check())
                                <li>
                                    <a class="dropdown-item" target="_blank" href="{{ route('admin.dashboard') }}">
                                        Admin Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" target="_blank" href="{{ route('logout') }}">
                                        Logout
                                    </a>
                                </li>
                            @endif

                            @if (Auth::guard('web')->check())
                                <li>
                                    <a class="dropdown-item" target="_blank" href="{{ route('user.dashboard') }}">
                                        User Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a wire:navigate class="dropdown-item"  href="{{ route('orders.index') }}">
                                        Orders
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
@endif
                      <livewire:site.cart.cart-badge />

                    </div>
                        @guest('web')
                    
                    <a wire:navigate href="{{ route('login') }}" class="btn-signin"> Login</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav">
        <div class="mobile-header">
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
             @if (get_setting('web_logo'))
                        <img loading="lazy" title="Logo" role="img"  class="brand-logo" alt="Company Logo" 
                            src="{{ uploaded_asset(get_setting('web_logo')) }}" >
                    @else
                        {{ get_setting('company_name') }}
                    @endif
            <!-- <a href="{{ route('site.index') }}" class="mobile-brand">DR AULAKH<span>HS</span></a> -->
            
            
                      <livewire:site.cart.cart-badge />
        </div>
        
        <!-- Mobile Search (Hidden by default) -->
        <div class="mobile-search-container" id="mobileSearch" style="display: none;">
            <i class="fas fa-search mobile-search-icon"></i>
            <input type="text" class="mobile-search-box" placeholder="Search health topics...">
        </div>
    </nav>
<div class="mobile-menu-overlay" id="mobileMenu">
    <div class="mobile-menu-container">
        <!-- Header -->
        <div class="mobile-menu-header">
            <div class="mobile-brand">
                @if (get_setting('web_logo'))
                        <img loading="lazy" title="Logo" role="img"  class="brand-logo" alt="Company Logo" 
                            src="{{ uploaded_asset(get_setting('web_logo')) }}" >
                    @else
                        {{ get_setting('company_name') }}
                    @endif
            </div>
            <button class="mobile-menu-close" onclick="toggleMobileMenu()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="mobile-nav-scroll">
            <div class="mobile-nav-links">
                <!-- Home -->
               <a href="{{ route('site.index') }}" class="mobile-nav-link">
    <div class="nav-link-inner">
        <div class="nav-icon-badge">
            <i class="fas fa-home"></i>
        </div>
        <div class="nav-text">
            <span class="nav-title">Home</span>
        </div>
    </div>
    <i class="fas fa-chevron-right nav-arrow"></i>
</a>


                <!-- Science Backed Supplements -->
                <div class="mobile-dropdown">
                    <div class="mobile-nav-link dropdown-trigger" onclick="event.preventDefault(); event.stopImmediatePropagation(); toggleMobileDropdown(this)"
>
                        <div class="nav-link-inner">
                            <div class="nav-icon-badge">
                                <i class="fas fa-capsules"></i>
                            </div>
                            <div class="nav-text">
                                <span class="nav-title">Science-Backed Supplements</span>
                            </div>
                        </div>
                        <div class="dropdown-actions">
                            <a href="{{ route('site.products') }}" class="nav-action-btn" onclick="event.stopPropagation()">
                                <i class="fas fa-shopping-bag"></i>
                            </a>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </div>
                    </div>
                    
                    <div class="mobile-submenu">
                        <div class="submenu-section">
                            <h4 class="submenu-title">
                                <i class="fas fa-flask"></i>
                                Shop & Research
                            </h4>
                          
                           
                        </div>
                    </div>
                </div>

              
              
                    
                </div>

                <!-- Guided Purchase -->
               
                <a  wire:navigate href="{{ route('login') }}" class="mobile-nav-link">
                    <div class="nav-link-inner">
                        <div class="nav-icon-badge">
                           <i class="fas fa-user"></i>

                        </div>
                        <div class="nav-text">
                            <span class="nav-title">Login / Register</span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right nav-arrow"></i>
                </a>
            </div>
        </div>

       
    </div>
</div>

<style>
/* Mobile Menu Overlay */
.mobile-menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(10px);
    z-index: 1000;
    display: none;
    animation: fadeIn 0.3s ease;
}
.mobile-menu-container {
    position: fixed;
}

.mobile-menu-overlay.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Menu Container */
.mobile-menu-container {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    width: 90%;
    max-width: 380px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    box-shadow: -5px 0 30px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    animation: slideIn 0.3s ease;
    overflow: hidden;
}

@keyframes slideIn {
    from { transform: translateX(100%); }
    to { transform: translateX(0); }
}

/* Header */
.mobile-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    background: white;
    border-bottom: 1px solid #eef2f7;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.mobile-brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.mobile-logo {
    width: 40px;
    height: 40px;
    border-radius: 10px;
}

.mobile-brand-name {
    font-size: 20px;
    font-weight: 700;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.mobile-menu-close {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #4b5563;
    cursor: pointer;
    transition: all 0.25s ease;
}

.mobile-menu-close:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
    transform: rotate(90deg);
}

/* Scrollable Nav Area */
.mobile-nav-scroll {
    flex: 1;
    overflow-y: auto;
    /* padding: 20px 0; */
    -webkit-overflow-scrolling: touch;
}

.mobile-nav-links {
    padding: 0;
}

/* Nav Links */
.mobile-nav-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    text-decoration: none;
    color: #1f2937;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.25s ease;
    position: relative;
    background: white;
}

.mobile-nav-link:hover {
    background: linear-gradient(90deg, #f0f9ff 0%, #ffffff 50%);
    padding-left: 28px;
}

.nav-link-inner {
    display: flex;
    align-items: center;
    gap: 16px;
    flex: 1;
}

.nav-icon-badge {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-icon-badge i {
    font-size: 22px;
    color: var(--primary-blue);
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.science-badge, .health-badge, .doctor-badge, .guide-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    font-size: 10px;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: white;
}

.science-badge { background: linear-gradient(135deg, #f59e0b, #d97706); }
.health-badge { background: linear-gradient(135deg, #10b981, #059669); }
.doctor-badge { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.guide-badge { background: linear-gradient(135deg, #ec4899, #db2777); }

.nav-text {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.nav-title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
}

.nav-subtitle {
    font-size: 13px;
    color: #6b7280;
    font-weight: 400;
}

.dropdown-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.nav-action-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4b5563;
    text-decoration: none;
    transition: all 0.2s ease;
}

.nav-action-btn:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-2px);
}

.dropdown-arrow {
    font-size: 14px;
    color: #9ca3af;
    transition: transform 0.3s ease;
}

/* Dropdown Submenu */
.mobile-dropdown.active .mobile-nav-link {
    background: #f0f9ff;
    border-left: 4px solid #3b82f6;
    padding-left: 20px;
}

.mobile-dropdown.active .dropdown-arrow {
    transform: rotate(180deg);
    color: #3b82f6;
}

.mobile-submenu {
    max-height: 0;
    overflow: hidden;
    background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.mobile-dropdown.active .mobile-submenu {
    max-height: 500px;
}

.submenu-section {
    padding: 20px 24px;
    border-bottom: 1px solid #e5e7eb;
}

.submenu-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 600;
    color: #4b5563;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #dbeafe;
}

.submenu-link {
    display: block;
    text-decoration: none;
    margin-bottom: 12px;
}

.submenu-link:last-child {
    margin-bottom: 0;
}

.submenu-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px;
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    transition: all 0.25s ease;
}

.submenu-item:hover {
    transform: translateX(4px);
    border-color: #bfdbfe;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
}

.submenu-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: white;
    flex-shrink: 0;
}

.shop-icon { background: linear-gradient(135deg, #f59e0b, #ea580c); }
.research-icon { background: linear-gradient(135deg, #0891b2, #0e7490); }
.article-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.faq-icon { background: linear-gradient(135deg, #10b981, #059669); }

.submenu-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.submenu-content span {
    font-size: 15px;
    font-weight: 600;
    color: #1f2937;
}

.submenu-content small {
    font-size: 12px;
    color: #6b7280;
}

/* Action Footer */
.mobile-action-footer {
    background: white;
    border-top: 1px solid #e5e7eb;
    padding: 20px;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
}

.user-actions {
    margin-bottom: 20px;
}

.mobile-login-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    width: 100%;
    padding: 16px;
    background: var(--primary-blue);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
}

.mobile-login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    color: white;
}

.mobile-contact-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f9fafb;
    border-radius: 10px;
    font-size: 14px;
    color: #4b5563;
}

.contact-item i {
    color: #3b82f6;
    font-size: 16px;
}

/* Scrollbar Styling */
.mobile-nav-scroll::-webkit-scrollbar {
    width: 4px;
}

.mobile-nav-scroll::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.mobile-nav-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.mobile-nav-scroll::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Responsive */
@media (max-width: 480px) {
    .mobile-menu-container {
        width: 100%;
        max-width: 100%;
    }
    
    .mobile-nav-link {
        padding: 16px 20px;
    }
    
    .nav-icon-badge i {
        width: 42px;
        height: 42px;
        font-size: 20px;
    }
}
</style>

<script>
document.querySelector('.mobile-menu-container')
    .addEventListener('click', function(e){
        e.stopPropagation();
});

function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('active');
    document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
}

function toggleMobileDropdown(element) {
    const dropdown = element.closest('.mobile-dropdown');
    const allDropdowns = document.querySelectorAll('.mobile-dropdown');

    allDropdowns.forEach(d => {
        if (d !== dropdown) d.classList.remove('active');
    });

    dropdown.classList.toggle('active');
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const menu = document.getElementById('mobileMenu');
        if (menu.classList.contains('active')) {
            toggleMobileMenu();
        }
    }
});

</script>

{{--
<header>
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-7 t-bar">
                    <div class="top-location">
                        <i class="las la-map-marker text-white"></i>
                       
                        <select id="state-select" class="top-select">
                            <option value="">Select State</option>
                     
                        </select>
                    </div>

                    <div class="top-location">
                        <i class="las la-map-marker text-white"></i>
                        <select id="city-select" class="top-select">
                            <option value="">Select District</option>
                        </select>
                    </div>
                    <div class="top-location">
                        <i class="las la-map-marker text-white"></i>
                        <select id="block-select" class="top-select">
                            <option value="">Select city</option>
                        </select>
                    </div>
                </div>
               
                  <div class="col-sm-5">
                    <ul class="top-act">
                        @if (get_setting('facebook_link'))
                            <li><a href="{{ get_setting('facebook_link') }}"><i class="lab la-facebook-f"
                                        aria-hidden="true"></i></a></li>
                        @endif
                        @if (get_setting('instagram_link'))
                            <li><a href="{{ get_setting('instagram_link') }}"><i class="lab la-instagram"
                                        aria-hidden="true"></i></a></li>
                        @endif
                        @if (get_setting('youtube_link'))
                            <li><a href="{{ get_setting('youtube_link') }}"><i class="lab la-youtube"
                                        aria-hidden="true"></i></a></li>
                        @endif
                        @if (get_setting('linkedin_link'))
                            <li><a href="{{ get_setting('linkedin_link') }}"><i class="lab la-linkedin"
                                        aria-hidden="true"></i></a></li>
                        @endif
                        @if (get_setting('twitter_link'))
                            <li><a href="{{ get_setting('twitter_link') }}"><i class="lab la-twitter"
                                        aria-hidden="true"></i></a></li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
      <div class="main-menu">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
            <div class="container">
                <a href="{{ route('site.index') }}" class="brand-link">
                    @if (get_setting('web_logo'))
                        <img loading="lazy" title="Logo" role="img" alt="Company Logo" style="height: 45px;"
                            src="{{ uploaded_asset(get_setting('web_logo')) }}" class="img-fluid">
                    @else
                        {{ get_setting('company_name') }}
                    @endif

                </a>


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('site.index') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('site.index') }}">Home</a>
                        </li>

                     


                    </ul>


                    @if (Auth::guard('admin')->check() ||
                            Auth::guard('web')->check() )
                        <div class="dropdown">
                            <button class="btn dropdown-toggle " type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                @if (Auth::guard('admin')->check())
                                    <li><a class="dropdown-item" target="_blank"
                                            href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                @endif

                                @if (Auth::guard('web')->check())
                                    <li><a class="dropdown-item" target="_blank"
                                            href="{{ route('user.dashboard') }}">User Dashboard</a></li>
                                @endif

                               

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>

                            </ul>
                        </div>
                    @endif





                    <ul class="header-right">
                        @guest('web')
                            <li><a wire:navigate href="{{ route('login') }}" class="login-btn">Login</a></li>
                            <li><a wire:navigate href="{{ route('register') }}" class="register-btn">Register<i
                                        class="las la-arrow-right"></i></a>
                            </li>
                        @endguest

                    </ul>


                </div>
            </div>
        </nav>
    </div>
</header>
--}}