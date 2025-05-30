<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  
    public function index()
    {
    $user = Auth::user();

    if ($user->role === 'admin') {
        // Admin sees all posts
        $postsCount = Post::count();
        $categoriesCount = Category::count();
        $pendingPostsCount = Post::where('status', 0)->count();
        $archivedPostsCount = Post::where('status', 3)->count();
    } else {
        // Writer sees only their own posts
        $postsCount = Post::where('user_id', $user->id)->count();
        $categoriesCount = 0; // Optional: writers may not need this
        $pendingPostsCount = Post::where('user_id', $user->id)->where('status', 0)->count();
        $archivedPostsCount = Post::where('user_id', $user->id)->where('status', 3)->count();
    }

    return view('admin.dashboard.index', compact(
        'postsCount',
        'categoriesCount',
        'pendingPostsCount',
        'archivedPostsCount'
    ));

    }   
}
