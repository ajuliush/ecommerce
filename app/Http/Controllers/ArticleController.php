<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view article', only: ['index']),
            new Middleware('permission:edit article', only: ['edit']),
            new Middleware('permission:create article', only: ['create']),
            new Middleware('permission:delete article', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        $articles = $query->paginate(10);
        return view('backend.article.list', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'  => 'required|min:3',
            'author'  => 'required|min:3'
        ]);
        if ($validator->passes()) {
            Article::create([
                'title' => $request->title,
                'text' => $request->text,
                'author' => $request->author
            ]);
            return redirect()->route('article.index')->with('success', 'Article created successfully');
        } else {
            return redirect()->route('article.create')->withInput()->withErrors($validator);
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
        $article = Article::find($id);
        return view('backend.article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title'  => 'required|min:3',
            'author'  => 'required|min:3',
        ]);
        if ($validator->passes()) {
            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            $article->update();
            return redirect()->route('article.index')->with('success', 'Article update successfully');
        } else {
            return redirect()->route('article.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Article::findOrFail($id);
        if ($role == null) {
            session()->flash('error', 'Article not found');
            return response()->json([
                'status' => 'false',
            ]);
        }
        $role->delete();
        session()->flash('error', 'Article deleted successfully');
        return response()->json([
            'status' => 'true',
        ]);
    }
}
