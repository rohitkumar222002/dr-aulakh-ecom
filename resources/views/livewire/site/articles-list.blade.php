<div>
    
@section('meta_title'){{ 'Articles  in '.config('app.name') }} @stop
@section('meta_keywords') {{ 'Articles in '.config('app.name') }} @stop
@section('meta_description') {{ 'Articles in '.config('app.name')}} @stop
<div class="articles-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="header-content">
                <h1 class="page-title">Latest Articles</h1>
                <p class="page-subtitle">Read insightful content from our writers</p>
                
                <!-- Search Box -->
                <div class="article-search-bar">
    <div class="article-search-box">
        <i class="fas fa-search"></i>
        <input type="text" 
               wire:model.debounce.500ms="search"
               placeholder="Search articles...">

        @if($search)
        <button class="clear-btn" wire:click="$set('search', '')">
            <i class="fas fa-times"></i>
        </button>
        @endif
    </div>

    <div class="article-sort-box">
        <select wire:model="sortBy">
            <option value="latest">Latest</option>
            <option value="oldest">Oldest</option>
            <option value="title">Title A-Z</option>
        </select>
    </div>
</div>

            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container main-container">
        <div class="layout">
            <!-- Articles List -->
            <div class="articles-container">
                @if($articles->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                    </div>
                    <h3>No articles found</h3>
                    <p>@if($search) Try a different search term @else No articles available yet @endif</p>
                    @if($search)
                    <button class="btn-clear-search" wire:click="$set('search', '')">
                        Clear Search
                    </button>
                    @endif
                </div>
                @else
                <div class="articles-grid">
                    @foreach($articles as $article)
                    <div class="article-card">
                        <!-- Article Image -->
                        <div class="article-image">
                            <a href="{{ route('articles.show', $article->slug) }}">
                                @if($article->thumbnail)
                                <img src="{{ uploaded_asset($article->thumbnail) }}" 
                                     alt="{{ $article->title }}"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif
                                <div class="no-image {{ $article->thumbnail ? 'hidden' : '' }}">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            </a>
                        </div>
                        
                        <!-- Article Content -->
                        <div class="article-content">
                            <div class="article-meta">
                                <span class="date">
                                    <i class="far fa-calendar"></i>
                                    {{ $article->created_at->format('M d, Y') }}
                                </span>
                                @if($article->author)
                                <span class="author">
                                    <i class="fas fa-user"></i>
                                    {{ $article->author->name }}
                                </span>
                                @endif
                            </div>
                            
                            <h3 class="article-title">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            
                            @if($article->excerpt)
                            <p class="article-excerpt">
                                {{ Str::limit($article->excerpt, 150) }}
                            </p>
                            @endif
                            
                            <div class="article-footer">
                                <a href="{{ route('articles.show', $article->slug) }}" class="read-more">
                                    Read More 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($articles->hasPages())
                <div class="pagination-wrapper">
                    {{ $articles->links('pagination::bootstrap-5') }}
                </div>
                @endif
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Recent Articles -->
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
                
                <!-- Newsletter -->
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

                <!-- Popular Tags -->
                <div class="sidebar-card tags-card">
                    <div class="sidebar-header">
                        <h3 class="sidebar-title">
                            <i class="fas fa-tags"></i>
                            Popular Tags
                        </h3>
                    </div>
                    <div class="tags-list">
                        <a href="#" class="tag">Technology</a>
                        <a href="#" class="tag">Business</a>
                        <a href="#" class="tag">Lifestyle</a>
                        <a href="#" class="tag">Travel</a>
                        <a href="#" class="tag">Health</a>
                        <a href="#" class="tag">Education</a>
                        <a href="#" class="tag">Finance</a>
                        <a href="#" class="tag">Design</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle image loading errors
    document.querySelectorAll('.article-image img').forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const noImage = this.nextElementSibling;
            if (noImage && noImage.classList.contains('no-image')) {
                noImage.style.display = 'flex';
            }
        });
    });

    // Handle recent article image loading errors
    document.querySelectorAll('.recent-image img').forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const noImage = this.nextElementSibling;
            if (noImage && noImage.classList.contains('no-image-small')) {
                noImage.style.display = 'flex';
            }
        });
    });
});
</script>
</div>
