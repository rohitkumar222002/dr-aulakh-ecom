<?php

namespace App\Livewire\Site;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;
use Illuminate\Support\Str;

class ArticlesList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'latest';
    public $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'latest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Base query for active articles only
        $query = Article::where('is_active', 1);

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $articles = $query->paginate($this->perPage);

        // Get recent articles for sidebar (latest 5)
        $recentArticles = Article::where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('livewire.site.articles-list', compact(
            'articles', 
            'recentArticles'
        ));
    }
}