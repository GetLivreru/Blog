<?php

namespace App\Http\Controllers\Personal\Main;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function __invoke() {
        $likedCounts = Post::whereHas('likedUsers', function($query) {
            $query->where('user_id', Auth::id());
        })->count();
        
        $commentCount = Comment::where('user_id', Auth::id())->count();
        
        return view('personal.main.index', compact('likedCounts', 'commentCount'));
    }
}
