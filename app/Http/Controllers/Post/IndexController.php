<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;

class IndexController extends Controller
{
    public function __invoke()
    {
        $posts = Post::paginate(5);
        
        // Получаем случайные посты только если они есть
        $randomPosts = collect();
        $likedPosts = collect();
        
        if (Post::count() > 0) {
            $randomPosts = Post::get()->random(min(4, Post::count()));
            $likedPosts = Post::withCount('likedUsers')
                ->orderBy('liked_users_count', 'DESC')
                ->get()
                ->take(4);
        }
        
        return view('post.index', compact('posts', 'randomPosts', 'likedPosts'));
    }
}
