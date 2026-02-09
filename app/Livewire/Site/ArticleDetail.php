<?php

namespace App\Livewire\Site;

use Livewire\Component;
use App\Models\Article;
use Illuminate\Support\Str;

class ArticleDetail extends Component
{
    public $slug;
    public $article;
    public $previousArticle;
    public $nextArticle;
    public $recentArticles;
    public $popularArticles;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadArticle();
        $this->loadRelatedArticles();
    }

    public function loadArticle()
    {
        $this->article = Article::where('slug', $this->slug)
            ->where('is_active', 1)
            ->firstOrFail();

        // Get previous and next articles
        $this->previousArticle = Article::where('is_active', 1)
            ->where('id', '<', $this->article->id)
            ->orderBy('id', 'desc')
            ->first();

        $this->nextArticle = Article::where('is_active', 1)
            ->where('id', '>', $this->article->id)
            ->orderBy('id', 'asc')
            ->first();
    }

    public function loadRelatedArticles()
    {
        // Get recent articles
        $this->recentArticles = Article::where('is_active', 1)
            ->where('id', '!=', $this->article->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get popular articles (you can implement view counting logic)
        $this->popularArticles = Article::where('is_active', 1)
            ->where('id', '!=', $this->article->id)
            ->orderBy('created_at', 'desc') // Replace with views if you have that column
            ->take(5)
            ->get();
    }

    // Share methods
    public function shareFacebook()
    {
        $url = route('articles.show', $this->article->slug);
        return redirect()->away("https://www.facebook.com/sharer/sharer.php?u=" . urlencode($url));
    }

    public function shareTwitter()
    {
        $url = route('articles.show', $this->article->slug);
        $title = $this->article->title;
        return redirect()->away("https://twitter.com/intent/tweet?text=" . urlencode($title . ' ' . $url));
    }

    public function shareWhatsapp()
    {
        $url = route('articles.show', $this->article->slug);
        $title = $this->article->title;
        return redirect()->away("https://wa.me/?text=" . urlencode($title . ' ' . $url));
    }

    public function render()
    {
        return view('livewire.site.article-detail', [
            'article' => $this->article,
            'previousArticle' => $this->previousArticle,
            'nextArticle' => $this->nextArticle,
            'recentArticles' => $this->recentArticles,
            'popularArticles' => $this->popularArticles,
        ]);
    }
}