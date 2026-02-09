<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(20);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'thumbnail'   => 'nullable|string',
            'images'      => 'nullable|string',
            'content'     => 'nullable|string',
            'excerpt'     => 'nullable|string',
            'is_active'   => 'required|boolean',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['author_id'] = auth()->id();

        Article::create($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article created');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'thumbnail'   => 'nullable|string',
            'images'      => 'nullable|string',
            'content'     => 'nullable|string',
            'excerpt'     => 'nullable|string',
            'is_active'   => 'required|boolean',
        ]);

        if ($article->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title']);
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article updated');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Article deleted',
        ]);
    }
}
