<div class="article-detail-page">
    @section('meta_title'){{ $article->meta_title ?? $article->title }} @stop
    @section('meta_keywords') {{ $article->meta_keywords ?? $article->title }} @stop
    @section('meta_description') {{ $article->meta_description ?? $article->title }} @stop
    @section('meta_image'){{ uploaded_asset($article->thumbnail) }}@stop

    <!-- Minimal Breadcrumb -->
    <!-- <div class="minimal-breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="breadcrumb-divider">/</span>
                <a href="{{ route('site.education') }}">Articles</a>
                <span class="breadcrumb-divider">/</span>
                <span class="current-page">{{ Str::limit($article->title, 35) }}</span>
            </nav>
        </div>
    </div> -->
    <div class="page-header">
        <div class="container">
            <div class="header-content">
                <h1 class="page-title">{{ Str::limit($article->title, 35) }}</h1>
                <p class="page-subtitle">{{ Str::limit($article->excerpt, 10) }}</p>                              
            </div>
        </div>
    </div>

    <!-- Article Header -->
    <div class="article-header">
        <div class="container">
            <div class="header-content">
                
                @if($article->excerpt)
                <p class="article-subtitle d-none">{{ $article->excerpt }}</p>
                @endif
                
                <!-- Article Meta -->
                <div class="article-meta-grid">
                    <!-- Author Info -->
                    @if($article->author)
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="meta-content">
                            <span class="meta-label">Author</span>
                            <span class="meta-value">{{ $article->author->name }}</span>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Publish Date -->
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="meta-content">
                            <span class="meta-label">Published</span>
                            <span class="meta-value">{{ $article->created_at->format('F d, Y') }}</span>
                        </div>
                    </div>
                    
                    <!-- Reading Time -->
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="meta-content">
                            <span class="meta-label">Reading Time</span>
                            @php
                                $wordCount = str_word_count(strip_tags($article->content));
                                $readingTime = ceil($wordCount / 200);
                            @endphp
                            <span class="meta-value">{{ $readingTime }} min read</span>
                        </div>
                    </div>
                    
                    <!-- Views -->
                    @if($article->views > 0)
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="meta-content">
                            <span class="meta-label">Views</span>
                            <span class="meta-value">{{ number_format($article->views) }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Image with Overlay -->
    @if($article->thumbnail)
    <div class="hero-image-container">
        <div class="container">
            <div class="hero-image-wrapper">
                <img src="{{ uploaded_asset($article->thumbnail) }}" 
                     alt="{{ $article->title }}"
                     class="hero-image"
                     loading="lazy"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <div class="image-overlay"></div>
                <div class="image-placeholder hidden">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content Area -->
    <div class="container">
        <div class="content-wrapper">
            <!-- Main Article Content -->
            <main class="article-main-content">
                <!-- Share Floating -->
                <div class="share-floating">
                    <div class="share-label">Share</div>
                    <button class="share-icon facebook" wire:click="shareFacebook" title="Share on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="share-icon twitter" wire:click="shareTwitter" title="Share on Twitter">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="share-icon whatsapp" wire:click="shareWhatsapp" title="Share on WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                    <button class="share-icon copy-link" onclick="copyArticleLink()" title="Copy link">
                        <i class="fas fa-link"></i>
                    </button>
                </div>

                <!-- Article Content -->
                <article class="article-body">
                    <div class="content-body">
                        {!! $article->content !!}
                    </div>
                    
                    <!-- Tags Section -->
                    <div class="tags-section">
                        <h3 class="section-title">
                            <i class="fas fa-tags"></i>
                            Article Tags
                        </h3>
                        <div class="tags-container">
                            @if($article->category)
                            <a href="#" class="tag-link">{{ $article->category->name }}</a>
                            @endif
                            <span class="tag">Education</span>
                            <span class="tag">Blog</span>
                            <span class="tag">Learning</span>
                            <span class="tag">Knowledge</span>
                        </div>
                    </div>

                    <!-- Author Bio -->
                    @if($article->author && $article->author->bio)
                    <div class="author-bio">
                        <div class="author-avatar-lg">
                            @if($article->author->avatar)
                            <img src="{{ uploaded_asset($article->author->avatar) }}" alt="{{ $article->author->name }}">
                            @else
                            <div class="avatar-initials">
                                {{ substr($article->author->name, 0, 2) }}
                            </div>
                            @endif
                        </div>
                        <div class="bio-content">
                            <h4>About the Author</h4>
                            <h5>{{ $article->author->name }}</h5>
                            <p>{{ $article->author->bio }}</p>
                            @if($article->author->social_links)
                            <div class="author-social">
                                @foreach(json_decode($article->author->social_links, true) as $platform => $link)
                                <a href="{{ $link }}" class="social-link" target="_blank">
                                    <i class="fab fa-{{ $platform }}"></i>
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Article Actions -->
                    <div class="article-actions">
                        <div class="action-group">
                            <button class="action-btn like-btn" onclick="likeArticle()">
                                <i class="far fa-heart"></i>
                                <span>Like</span>
                                <span class="count" id="likeCount">0</span>
                            </button>
                            <button class="action-btn bookmark-btn" onclick="bookmarkArticle()">
                                <i class="far fa-bookmark"></i>
                                <span>Save</span>
                            </button>
                        </div>
                        <div class="share-main">
                            <span class="share-text">Share this article:</span>
                            <div class="share-buttons">
                                <button class="share-btn fb" wire:click="shareFacebook">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button class="share-btn tw" wire:click="shareTwitter">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button class="share-btn wa" wire:click="shareWhatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                                <button class="share-btn li" onclick="shareLinkedIn()">
                                    <i class="fab fa-linkedin-in"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Article Navigation -->
                    <div class="article-navigation">
                        @if($previousArticle)
                        <a href="{{ route('articles.show', $previousArticle->slug) }}" class="nav-card prev">
                            <div class="nav-arrow">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Previous Article</span>
                                <h4>{{ Str::limit($previousArticle->title, 60) }}</h4>
                                <span class="nav-date">{{ $previousArticle->created_at->format('M d, Y') }}</span>
                            </div>
                        </a>
                        @endif
                        
                        @if($nextArticle)
                        <a href="{{ route('articles.show', $nextArticle->slug) }}" class="nav-card next">
                            <div class="nav-content">
                                <span class="nav-label">Next Article</span>
                                <h4>{{ Str::limit($nextArticle->title, 60) }}</h4>
                                <span class="nav-date">{{ $nextArticle->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="nav-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        @endif
                    </div>
                </article>
            </main>

            <!-- Sidebar -->
            <aside class="article-sidebar">
                <!-- Newsletter Card -->
                    <div class="sidebar-card newsletter-card">
                    <div class="newsletter-content">
                        <div class="newsletter-header">
                            <div class="newsletter-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <h4>Subscribe to Newsletter</h4>
                        </div>
                        <p class="newsletter-text">Get latest articles in your inbox</p>
                        <div class="newsletter-form">
                            <div class="input-group">
                                <input type="email" placeholder="Your email address" class="newsletter-input w-50">
                                <button type="button" class="newsletter-btn">
                                    Subscribe
                                </button>
                            </div>
                            <p class="newsletter-note">No spam, unsubscribe anytime</p>
                        </div>
                    </div>
                </div>
                @if($recentArticles->count() > 0)
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3 class="sidebar-title">
                            <i class="fas fa-history"></i>
                            Recent Articles
                        </h3>
                    </div>
                    <div class="recent-list">
                        @foreach($recentArticles as $article)
                        <a href="{{ route('articles.show', $article->slug) }}" class="recent-item">
                            <div class="recent-image">
                                @if($article->thumbnail)
                                <img src="{{ uploaded_asset($article->thumbnail) }}" 
                                     alt="{{ $article->title }}"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif
                                <div class="no-image-small {{ $article->thumbnail ? 'hidden' : '' }}">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                            <div class="recent-content">
                                <h4>{{ Str::limit($article->title, 50) }}</h4>
                                <div class="recent-meta">
                                    @if($article->author)
                                    <span class="recent-author">{{ $article->author->name }}</span>
                                    @endif
                                    <span class="recent-date">{{ $article->created_at->format('M d') }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>
    </div>

    <!-- Related Articles -->
   

    <!-- Back to Top -->
    <button class="back-to-top" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>

    <style>
    /* Base Styles & Variables */
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --secondary: #7c3aed;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --text-light: #9ca3af;
        --bg-light: #f9fafb;
        --bg-white: #ffffff;
        --border-color: #e5e7eb;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --radius-2xl: 1.5rem;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text-primary);
        line-height: 1.6;
        background: var(--bg-light);
    }

    .article-detail-page {
        min-height: 100vh;
    }

    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* Minimal Breadcrumb */
    .minimal-breadcrumb {
        padding: 1.5rem 0;
        background: var(--bg-white);
        border-bottom: 1px solid var(--border-color);
    }

    .minimal-breadcrumb nav {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
    }

    .minimal-breadcrumb a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.2s;
    }

    .minimal-breadcrumb a:hover {
        color: var(--primary);
    }

    .breadcrumb-divider {
        color: var(--text-light);
        font-size: 0.75rem;
    }

    .current-page {
        color: var(--text-primary);
        font-weight: 500;
    }

    /* Article Header */
    .article-header {
        padding: 3rem 0 2rem;
        background: var(--bg-white);
    }

    .header-content {
        max-width: 768px;
        margin: 0 auto;
        text-align: center;
    }

    .category-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        letter-spacing: 0.025em;
    }

    .main-title {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.2;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        letter-spacing: -0.025em;
    }

    .article-subtitle {
        font-size: 1.25rem;
        color: var(--text-secondary);
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    /* Article Meta Grid */
    .article-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        /* margin-top: 2rem; */
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .meta-icon {
        width: 3rem;
        height: 3rem;
        background: var(--bg-light);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.25rem;
    }

    .meta-content {
        text-align: left;
    }

    .meta-label {
        display: block;
        font-size: 0.75rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .meta-value {
        display: block;
        font-weight: 500;
        color: var(--text-primary);
    }

    /* Hero Image */
    .hero-image-container {
        padding: 2rem 0;
    }

    .hero-image-wrapper {
        position: relative;
        border-radius: var(--radius-2xl);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .hero-image {
        width: 100%;
        height: auto;
        max-height: 600px;
        object-fit: cover;
        display: block;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.1));
    }

    .image-placeholder {
        display: none;
        width: 100%;
        height: 400px;
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
        font-size: 4rem;
    }

    /* Content Wrapper */
    .content-wrapper {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 3rem;
        padding: 3rem 0;
    }

    /* Floating Share */
    .share-floating {
        position: sticky;
        top: 6rem;
        float: left;
        margin-left: -5rem;
        margin-right: 2rem;
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        padding: 1rem 0.5rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        z-index: 10;
    }

    .share-label {
        font-size: 0.75rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
        text-align: center;
    }

    .share-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: var(--radius-md);
        border: none;
        background: transparent;
        color: var(--text-secondary);
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 0.5rem;
    }

    .share-icon:hover {
        transform: translateY(-2px);
        color: white;
    }

    .share-icon.facebook:hover { background: #1877f2; }
    .share-icon.twitter:hover { background: #1da1f2; }
    .share-icon.whatsapp:hover { background: #25d366; }
    .share-icon.copy-link:hover { background: var(--primary); }

    /* Article Body */
    .article-body {
        background: var(--bg-white);
        border-radius: var(--radius-2xl);
        padding: 3rem;
        box-shadow: var(--shadow-lg);
    }

    .content-body {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--text-primary);
    }

    .content-body h2 {
        font-size: 2rem;
        font-weight: 700;
        margin: 2.5rem 0 1rem;
        color: var(--text-primary);
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border-color);
    }

    .content-body h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 2rem 0 1rem;
        color: var(--text-primary);
    }

    .content-body p {
        margin-bottom: 1.5rem;
    }

    .content-body img {
        max-width: 100%;
        height: auto;
        border-radius: var(--radius-lg);
        margin: 2rem 0;
        box-shadow: var(--shadow-md);
    }

    .content-body blockquote {
        border-left: 4px solid var(--primary);
        padding: 1.5rem 2rem;
        margin: 2rem 0;
        background: var(--bg-light);
        border-radius: 0 var(--radius-lg) var(--radius-lg) 0;
        font-style: italic;
        color: var(--text-secondary);
    }

    /* Tags Section */
    .tags-section {
        margin: 3rem 0;
        padding: 2rem 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--text-primary);
    }

    .section-title i {
        color: var(--primary);
    }

    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .tag-link, .tag {
        display: inline-block;
        padding: 0.5rem 1.25rem;
        background: var(--bg-light);
        color: var(--text-secondary);
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid transparent;
    }

    .tag-link:hover, .tag:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: translateY(-1px);
    }

    /* Author Bio */
    .author-bio {
        display: flex;
        gap: 2rem;
        margin: 3rem 0;
        padding: 2rem;
        background: var(--bg-light);
        border-radius: var(--radius-xl);
    }

    .author-avatar-lg {
        flex-shrink: 0;
        width: 5rem;
        height: 5rem;
    }

    .author-avatar-lg img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .avatar-initials {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .bio-content h4 {
        font-size: 0.875rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .bio-content h5 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .bio-content p {
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    .author-social {
        display: flex;
        gap: 1rem;
    }

    .social-link {
        width: 2.5rem;
        height: 2.5rem;
        background: var(--bg-white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        text-decoration: none;
        transition: all 0.2s;
    }

    .social-link:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    /* Article Actions */
    .article-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 3rem 0;
        padding: 2rem;
        background: var(--bg-light);
        border-radius: var(--radius-xl);
    }

    .action-group {
        display: flex;
        gap: 1rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.5rem;
        background: var(--bg-white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        font-weight: 500;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.2s;
    }

    .action-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-1px);
    }

    .action-btn i {
        font-size: 1.25rem;
    }

    .count {
        background: var(--primary);
        color: white;
        padding: 0.125rem 0.5rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        margin-left: 0.25rem;
    }

    .share-main {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .share-text {
        color: var(--text-light);
        font-size: 0.875rem;
    }

    .share-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .share-btn {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .share-btn:hover {
        transform: translateY(-2px);
    }

    .share-btn.fb { background: #1877f2; }
    .share-btn.tw { background: #1da1f2; }
    .share-btn.wa { background: #25d366; }
    .share-btn.li { background: #0a66c2; }

    /* Article Navigation */
    .article-navigation {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin: 3rem 0;
    }

    .nav-card {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        background: var(--bg-white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        text-decoration: none;
        color: inherit;
        transition: all 0.2s;
    }

    .nav-card:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .nav-arrow {
        width: 3rem;
        height: 3rem;
        background: var(--bg-light);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .nav-content {
        flex: 1;
    }

    .nav-label {
        display: block;
        font-size: 0.75rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .nav-content h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .nav-date {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .nav-card.next {
        text-align: right;
    }

    .nav-card.next .nav-content {
        order: 1;
    }

    .nav-card.next .nav-arrow {
        order: 2;
    }

    /* Sidebar Widgets */
    .article-sidebar {
        position: sticky;
        top: 6rem;
        height: fit-content;
    }

    .sidebar-widget {
        background: var(--bg-white);
        border-radius: var(--radius-xl);
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .widget-icon {
        width: 3rem;
        height: 3rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .sidebar-widget h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .sidebar-widget h3 i {
        color: var(--primary);
    }

    /* Newsletter Widget */
    .newsletter-widget {
        background: linear-gradient(135deg, #0d0d0e 0%, #1a1a1d 100%);
        color: white;
        text-align: center;
    }

    .newsletter-widget .widget-icon {
        background: rgba(255, 255, 255, 0.2);
        margin: 0 auto 1.5rem;
    }

    .newsletter-widget h3 {
        color: white;
    }

    .newsletter-widget p {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 1.5rem;
    }

    .newsletter-form {
        display: flex;
        gap: 0.5rem;
    }

    .email-input {
        flex: 1;
        padding: 0.875rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-lg);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .email-input:focus {
        outline: none;
        border-color: white;
        background: rgba(255, 255, 255, 0.15);
    }

    .email-input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .subscribe-btn {
        padding: 0.875rem 1.5rem;
        background: white;
        color: var(--primary);
        border: none;
        border-radius: var(--radius-lg);
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .subscribe-btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .privacy-note {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.7);
        margin-top: 1rem;
    }

    /* TOC Widget */
    .toc-content {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    .toc-content::-webkit-scrollbar {
        width: 4px;
    }

    .toc-content::-webkit-scrollbar-track {
        background: var(--bg-light);
        border-radius: 2px;
    }

    .toc-content::-webkit-scrollbar-thumb {
        background: var(--text-light);
        border-radius: 2px;
    }

    .toc-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .toc-item:last-child {
        border-bottom: none;
    }

    .toc-link {
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 0.875rem;
        transition: color 0.2s;
        display: block;
    }

    .toc-link:hover {
        color: var(--primary);
    }

    /* Popular Widget */
    .popular-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .popular-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--bg-light);
        border-radius: var(--radius-lg);
        text-decoration: none;
        color: inherit;
        transition: all 0.2s;
    }

    .popular-item:hover {
        background: var(--bg-white);
        transform: translateX(4px);
    }

    .popular-rank {
        width: 2rem;
        height: 2rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.875rem;
        font-weight: 600;
        flex-shrink: 0;
    }

    .popular-content h4 {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        line-height: 1.4;
    }

    .popular-meta {
        font-size: 0.75rem;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Categories Widget */
    .categories-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        background: var(--bg-light);
        border-radius: var(--radius-lg);
        text-decoration: none;
        color: var(--text-secondary);
        transition: all 0.2s;
    }

    .category-item:hover {
        background: var(--primary);
        color: white;
        transform: translateX(4px);
    }

    .category-name {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .category-count {
        font-size: 0.75rem;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.125rem 0.5rem;
        border-radius: var(--radius-full);
    }

    .category-item:hover .category-count {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Related Articles */
    .related-articles {
        padding: 4rem 0;
        background: var(--bg-light);
        border-top: 1px solid var(--border-color);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .section-title i {
        color: var(--primary);
    }

    .view-all {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        transition: gap 0.2s;
    }

    .view-all:hover {
        gap: 1rem;
    }

    .articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .article-card {
        background: var(--bg-white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s;
    }

    .article-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .card-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .article-card:hover .card-image img {
        transform: scale(1.05);
    }

    .card-image .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.3));
    }

    .card-content {
        padding: 1.5rem;
    }

    .card-category {
        display: inline-block;
        background: var(--bg-light);
        color: var(--primary);
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .card-content h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .card-content p {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .card-meta {
        font-size: 0.75rem;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Back to Top */
    .back-to-top {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 3rem;
        height: 3rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
        z-index: 1000;
        box-shadow: var(--shadow-lg);
    }

    .back-to-top.visible {
        opacity: 1;
        visibility: visible;
    }

    .back-to-top:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .content-wrapper {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .share-floating {
            display: none;
        }
        
        .main-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .article-body {
            padding: 2rem;
        }
        
        .article-meta-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .article-navigation {
            grid-template-columns: 1fr;
        }
        
        .article-actions {
            flex-direction: column;
            gap: 1.5rem;
            align-items: stretch;
        }
        
        .share-main {
            justify-content: center;
        }
        
        .main-title {
            font-size: 2rem;
        }
        
        .articles-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .container {
            padding: 0 1rem;
        }
        
        .article-header {
            padding: 2rem 0 1.5rem;
        }
        
        .article-meta-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .hero-image-wrapper {
            border-radius: var(--radius-lg);
        }
        
        .author-bio {
            flex-direction: column;
            text-align: center;
        }
        
        .author-social {
            justify-content: center;
        }
    }

    /* Utility Classes */
    .hidden {
        display: none !important;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>

<style>
/* Reset and Base */
.articles-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f5 100%);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Page Header */
.page-header {
    background: linear-gradient(135deg, #0d0d0e 0%, #1a1a1d 100%);
    color: white;
    padding: 70px 0 50px;
    margin-bottom: 40px;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #daa520 0%, #ffd700 100%);
}

.header-content {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.page-title {
    font-size: 42px;
    font-weight: 800;
    margin-bottom: 15px;
    background: linear-gradient(135deg, #daa520 0%, #ffd700 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.5px;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 18px;
    margin-bottom: 40px;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
}

/* Search Container */
.article-search-bar {
    max-width: 800px;
    margin: 0 auto;
    display: flex;
    gap: 15px;
    align-items: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(218, 165, 32, 0.2);
    border-radius: 12px;
    padding: 10px;
}

.article-search-box {
    flex: 1;
    position: relative;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 8px;
    overflow: hidden;
}

.article-search-box i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #daa520;
    z-index: 1;
}

.article-search-box input {
    width: 100%;
    padding: 16px 20px 16px 50px;
    border: none;
    background: transparent;
    font-size: 16px;
    color: #333;
    font-family: inherit;
}

.article-search-box input::placeholder {
    color: #999;
}

.article-search-box input:focus {
    outline: none;
}

.clear-btn {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.05);
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    color: #666;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.clear-btn:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #333;
}

.article-sort-box {
    position: relative;
}

.article-sort-box select {
    padding: 16px 45px 16px 20px;
    border: 1px solid rgba(218, 165, 32, 0.3);
    border-radius: 8px;
    font-size: 15px;
    background: rgba(255, 255, 255, 0.95);
    color: #333;
    cursor: pointer;
    appearance: none;
    font-family: inherit;
    min-width: 170px;
    transition: all 0.3s ease;
}

.article-sort-box select:focus {
    outline: none;
    border-color: #daa520;
    box-shadow: 0 0 0 3px rgba(218, 165, 32, 0.1);
}

.article-sort-box::after {
    content: '\f078';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #daa520;
    pointer-events: none;
    font-size: 14px;
}

/* Main Layout */
.main-container {
    padding-bottom: 80px;
}

.layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 40px;
    align-items: start;
}

/* Empty State */
.empty-state {
    background: white;
    padding: 60px 40px;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(218, 165, 32, 0.1);
}

.empty-icon {
    margin-bottom: 25px;
    color: #daa520;
}

.empty-icon svg {
    stroke: #daa520;
}

.empty-state h3 {
    font-size: 26px;
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: 700;
}

.empty-state p {
    color: #7f8c8d;
    margin-bottom: 30px;
    font-size: 16px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.btn-clear-search {
    background: linear-gradient(135deg, #daa520 0%, #ffd700 100%);
    color: #000;
    border: none;
    padding: 14px 32px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-clear-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(218, 165, 32, 0.3);
}

/* Articles Grid */
.articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

/* Article Card */
.article-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(218, 165, 32, 0.1);
}

.article-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    border-color: rgba(218, 165, 32, 0.3);
}

.article-image {
    height: 220px;
    overflow: hidden;
    position: relative;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.article-card:hover .article-image img {
    transform: scale(1.08);
}

.no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #daa520;
    font-size: 48px;
    background: linear-gradient(135deg, rgba(218, 165, 32, 0.1) 0%, rgba(255, 215, 0, 0.1) 100%);
}

.no-image.hidden {
    display: none;
}

.article-content {
    padding: 28px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.article-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 18px;
    font-size: 14px;
    color: #7f8c8d;
}

.article-meta i {
    margin-right: 8px;
    color: #daa520;
}

.article-title {
    font-size: 22px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 18px;
    line-height: 1.4;
    flex: 1;
}

.article-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.article-title a:hover {
    color: #daa520;
}

.article-excerpt {
    color: #5a6c7d;
    line-height: 1.7;
    margin-bottom: 25px;
    font-size: 15px;
    flex: 1;
}

.article-footer {
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid #f0f0f0;
}

.read-more {
    color: #daa520;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    padding: 8px 0;
}

.read-more:hover {
    gap: 15px;
    color: #ffd700;
}

.read-more svg {
    transition: transform 0.3s ease;
}

.read-more:hover svg {
    transform: translateX(5px);
}

/* Pagination */
.pagination-wrapper {
    margin-top: 60px;
}

/* Sidebar */
.sidebar {
    position: sticky;
    top: 100px;
    height: fit-content;
}

/* Sidebar Card */
.sidebar-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(218, 165, 32, 0.1);
    transition: all 0.3s ease;
}

.sidebar-card:hover {
    border-color: rgba(218, 165, 32, 0.3);
}

.sidebar-header {
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f0f0f0;
}

.sidebar-title {
    font-size: 18px;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.sidebar-title i {
    color: #daa520;
    font-size: 16px;
}

/* Recent Articles */
.recent-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.recent-item {
    display: flex;
    gap: 15px;
    text-decoration: none;
    color: inherit;
    padding: 15px;
    border-radius: 12px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.recent-item:hover {
    background: rgba(218, 165, 32, 0.1);
    transform: translateX(5px);
}

.recent-image {
    width: 70px;
    height: 70px;
    flex-shrink: 0;
    border-radius: 10px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.recent-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image-small {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #daa520;
    font-size: 20px;
    background: linear-gradient(135deg, rgba(218, 165, 32, 0.1) 0%, rgba(255, 215, 0, 0.1) 100%);
}

.no-image-small.hidden {
    display: none;
}

.recent-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.recent-content h4 {
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    line-height: 1.4;
}

.recent-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13px;
    color: #7f8c8d;
}

.recent-author {
    color: #daa520;
    font-weight: 500;
}

.recent-date {
    color: #7f8c8d;
}

/* Newsletter Card */
.newsletter-card {
    background: linear-gradient(135deg, #0d0d0e 0%, #1a1a1d 100%);
    color: white;
    border: 1px solid rgba(218, 165, 32, 0.3);
}

.newsletter-content {
    text-align: center;
}

.newsletter-header {
    margin-bottom: 20px;
}

.newsletter-icon {
    margin-bottom: 15px;
    color: #daa520;
}

.newsletter-content h4 {
    font-size: 20px;
    font-weight: 700;
    color: white;
    margin-bottom: 10px;
}

.newsletter-text {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 25px;
    font-size: 15px;
    line-height: 1.6;
}

.newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.input-group {
    display: flex;
    /* gap: 10px; */
}

.newsletter-input {
    flex: 1;
    padding: 16px 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    font-size: 15px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    transition: all 0.3s ease;
}

.newsletter-input:focus {
    outline: none;
    border-color: #daa520;
    background: rgba(255, 255, 255, 0.15);
}

.newsletter-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.newsletter-btn {
    background: linear-gradient(135deg, #daa520 0%, #ffd700 100%);
    color: #000;
    border: none;
    padding: 16px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.newsletter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(218, 165, 32, 0.3);
}

.newsletter-note {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.6);
    margin-top: 10px;
}

/* Tags Card */
.tags-card {
    background: white;
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.tag {
    background: rgba(218, 165, 32, 0.1);
    color: #daa520;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
    border: 1px solid transparent;
}

.tag:hover {
    background: rgba(218, 165, 32, 0.2);
    border-color: rgba(218, 165, 32, 0.3);
    color: #daa520;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .container {
        padding: 0 30px;
    }
}

@media (max-width: 992px) {
    .layout {
        grid-template-columns: 1fr;
        gap: 40px;
    }
        .article-search-box {
        /* width: 240px; */
        width: 100%;
        padding: 0;
        /* height: 43px; */
    }
    .sidebar {
        position: static;
        margin-top: 20px;
    }
    .newsletter-input{
            width: 100% !important;
    }
    .articles-grid {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    }
    .article-sort-box{
        width: 100%;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 50px 0 40px;
    }
    .newsletter-input{
            width: 100% !important;
    }
        .article-search-box {
        /* width: 240px; */
        width: 100%;
        padding: 0;
        /* height: 43px; */
    }
    .page-title {
        font-size: 36px;
    }
    
    .article-search-bar {
        flex-direction: column;
        gap: 15px;
    }
    
    .article-sort-box select {
        width: 100%;
    }
    
    .articles-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .article-image {
        height: 200px;
    }
    
    .input-group {
        flex-direction: column;
    }
    .article-sort-box{
        width: 100%;
    }
    .newsletter-btn {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .container {
        padding: 0 20px;
    }
    
    .page-header {
        padding: 40px 0 30px;
    }
    
    .page-title {
        font-size: 32px;
    }
        .article-search-box {
        /* width: 240px; */
        width: 100%;
        padding: 0;
        /* height: 43px; */
    }
    .article-sort-box{
        width: 100%;
    }
    .page-subtitle {
        font-size: 16px;
    }
    
    .article-content {
        padding: 25px;
    }
    
    .article-title {
        font-size: 20px;
    }
    
    .empty-state {
        padding: 50px 25px;
    }
    
    .sidebar-card {
        padding: 25px;
    }
}

.hidden {
    display: none !important;
}
</style>
    
</div>