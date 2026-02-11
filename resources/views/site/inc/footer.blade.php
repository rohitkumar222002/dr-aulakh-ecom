
<footer class="main-footer">
        <div class="footer-grid">
            <div class="footer-brand">
              @if (get_setting('web_logo'))
<div class="logo-wrapper">
    <span class="logo-container">
        <img 
            src="{{ uploaded_asset(get_setting('web_logo')) }}"
            alt="Dr. Aulakh Health Sciences"
            class="brand-logo">
        <!-- <sup class="tm">™</sup> -->
    </span>
</div>

@else
    {{ get_setting('company_name') }}
@endif
<style>
    .logo-wrapper {
    background: #fff;
    border-radius: 6px;
    display: inline-block;
}
.logo-container {
    position: relative;
    display: inline-block;
        padding: 7px;
}
.logo-brand {
   
    padding-right: 12px !important;
}


.tm {
        position: absolute;
    top: 22px;
    right: 2px;
    font-size: 20px;
    font-weight: bold;
    color: #182c5c;
}


</style>
                <!-- <div class="footer-tagline">Science. Simplicity. Honest Health.</div> -->
                <p class="footer-description">
                    {{get_setting('footer_about')}}
                </p>
                <div class="social-links">
                        @if (get_setting('youtube_link'))

                    <a href="{{ get_setting('youtube_link') }}" class="social-link">
                        <i class="fab fa-youtube"></i>
                    </a>
                    @endif
                        @if (get_setting('instagram_link'))
                    <a href="{{ get_setting('instagram_link') }}" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif

                 @if (get_setting('facebook_link'))
                    <a href="{{ get_setting('facebook_link') }}" class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                        @if (get_setting('linkedin_link'))

                    <a href="#" class="social-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                        @if (get_setting('twitter_link'))
        <a href="#" class="social-link">
                                <i class="fab fa-twitter-in"></i>
                            </a>
                            @endif
                </div>
               
            </div>
            
            <div class="footer-column">
                <h4>Category</h4>
                <ul class="footer-links">
                    <li><a href="#">Metabolic Health</a></li>
                    <li><a href="#">Insulin Resistance</a></li>
                    <li><a href="#">Diabetes Reversal</a></li>
                    <li><a href="#">Nutritional Science</a></li>
                    <li><a href="#">Blood Sugar Management</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Resources</h4>
                <ul class="footer-links">
                    <li><a href="#">Video Library</a></li>
                    <li><a href="#">Articles & Guides</a></li>
                    <li><a href="#">Research Summaries</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Free Downloads</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Connect</h4>
                <ul class="footer-links">
                    <li><a href="#">Contact Us</a></li>
                    @foreach (App\Models\Inc\CustomPages::where('status', 1)->orderBy('priority', 'asc')->whereIn('Show_in', [0, 2])->get() as $cus_pages)
                           <li> <a href="{{ route('custom.pages', $cus_pages->slug) }}"
                                class="">{{ $cus_pages->page_name }}</a>
                           </li>
                        @endforeach
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy;   {!! get_setting('copy_right') !!}</p>
            <!-- <p style="margin-top: 10px; font-size: 0.8rem; color: #888;">
                This information is for educational purposes only and is not a substitute for professional medical advice.
            </p> -->
        </div>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@livewireScripts
@stack('site-scripts')
