<!doctype html>
<html lang="en">

<head>
    @include('site.inc.style')
    <style>[x-cloak] { display: none !important; }</style>
<style>
      :root {
            --primary-blue: {{ get_setting('site_color') }} !important;
            --dark: #1a1a1a;
            --gray: #666666;
            --light-gray: #f5f5f5;
            --white: #ffffff;
        }
        .hero-section {
    position: relative;
    width: 100%;
    max-height: 450px !important;
    height: 450px !important;
    overflow: hidden;
}

.hero-slide {
    height: 450px !important;
    max-height: 450px !important;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Overlay full cover kare */
.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* Responsive Control */
@media (max-width: 768px) {
    .hero-section,
    .hero-slide {
        height: 350px;
        max-height: 350px;
    }
}

    </style>
</head>

<body>

    @include('site.inc.header')
    <livewire:site.toast />
<livewire:site.cart.mini-cart />

    {{ $slot }}
    @include('site.inc.footer')

    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu.style.display === 'block') {
                mobileMenu.style.display = 'none';
                document.body.style.overflow = 'auto';
            } else {
                mobileMenu.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        }
        
        // Mobile Search Toggle
        function toggleMobileSearch() {
            const mobileSearch = document.getElementById('mobileSearch');
            if (mobileSearch.style.display === 'block') {
                mobileSearch.style.display = 'none';
            } else {
                mobileSearch.style.display = 'block';
                setTimeout(() => {
                    mobileSearch.querySelector('.mobile-search-box').focus();
                }, 100);
            }
        }
        
        // Navigation Active State
        document.querySelectorAll('.nav-link, .mobile-nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                document.querySelectorAll('.nav-link, .mobile-nav-link').forEach(l => {
                    l.classList.remove('active');
                });
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Close mobile menu if open
                if (this.classList.contains('mobile-nav-link')) {
                    toggleMobileMenu();
                }
            });
        });
        
        // Search Box Focus Effect
        const searchBox = document.querySelector('.search-box');
        const searchIcon = document.querySelector('.search-icon');
        
        searchBox.addEventListener('focus', function() {
            searchIcon.style.color = 'var(--primary-blue)';
        });
        
        searchBox.addEventListener('blur', function() {
            searchIcon.style.color = 'var(--gray)';
        });
        
        // Smooth Scrolling for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    // Close mobile menu if open
                    if (document.getElementById('mobileMenu').style.display === 'block') {
                        toggleMobileMenu();
                    }
                    
                    // Calculate position
                    const headerOffset = 80;
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    // Smooth scroll
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const desktopNav = document.querySelector('.desktop-nav');
            const mobileNav = document.querySelector('.mobile-nav');
            
            if (window.scrollY > 50) {
                if (desktopNav) desktopNav.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
                if (mobileNav) mobileNav.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            } else {
                if (desktopNav) desktopNav.style.boxShadow = 'none';
                if (mobileNav) mobileNav.style.boxShadow = 'none';
            }
        });
    </script>
    <script>
const slides = document.querySelectorAll('.hero-slide');
let index = 0;

setInterval(() => {
    slides[index].classList.remove('active');
    index = (index + 1) % slides.length;
    slides[index].classList.add('active');
}, 10000);
</script>


</body>

</html>