<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\DataTables\PostDataTable;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Services\Admin\Post\PostService;
use App\Services\Admin\Category\CategoryService;

class PostController extends Controller
{
    // protected $categoryService;
    // protected $postService;

    public function __construct(protected CategoryService $categoryService, protected PostService $postService)
    {
        $this->categoryService = $categoryService;     
        $this->postService = $postService;   
    }
    /**
     * Display a listing of the resource.
     */
   public function index(PostDataTable $dataTable)
    {
        return $dataTable->render('admin.post.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $categories = $this->categoryService->get();
        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
       // dd($request->all());
       $data= $request->validated();
       try {
        $this->postService->createOrUpdate($data);
        return redirect()->route('admin.posts.index');
       } catch (\Throwable $th) {
        throw $th;
       }
      
      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
     try {
        $post = $this->postService->get($id, ['category', 'tags']);
        $categories = $this->categoryService->get();
        $tagNames = $post->tags->pluck('name')->implode(',');

        return view('admin.post.edit', compact('post', 'categories', 'tagNames'));
    } catch (\Throwable $th) {
        report($th); // optional: logs the exception
        abort(500, 'An error occurred while loading the edit form.');
    }
           
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $this->postService->createOrUpdate($data, $id);
            
            return redirect()->route('admin.posts.index');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->postService->delete($id);
            return redirect()->route('admin.posts.index');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
