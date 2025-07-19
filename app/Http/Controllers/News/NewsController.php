<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()->paginate(5)->items();

        return Inertia::render('news/index', [
            'news' => $news,
        ]);
    }

    public function show(News $news)
    {
        if (! $news->is_published || $news->published_at > now()) {
            abort(404);
        }

        return Inertia::render('news/show', [
            'news' => $news,
        ]);
    }
}
