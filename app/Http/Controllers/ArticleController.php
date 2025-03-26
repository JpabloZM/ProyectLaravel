<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('blog.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::orderBy('name')->get();
        return view('blog.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'blog_category_id' => 'required|exists:blog_categories,id',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'published_at' => 'nullable|date'
            ]);

            if ($request->hasFile('featured_image')) {
                $path = $request->file('featured_image')->store('blog', 'public');
                $validated['featured_image'] = $path;
            }

            // Asignar un autor por defecto (primer usuario)
            $user = User::first();
            if ($user) {
                $validated['author_id'] = $user->id;
            } else {
                // Crear un usuario si no existe ninguno
                $user = User::create([
                    'name' => 'Admin',
                    'email' => 'admin@example.com',
                    'password' => bcrypt('password')
                ]);
                $validated['author_id'] = $user->id;
            }

            $article = Article::create($validated);
            
            Log::info('Artículo creado: ' . $article->id);

            return redirect()->route('blog.articles.index')
                ->with('success', 'Artículo creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear artículo: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear el artículo: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load(['category', 'comments' => function($query) {
            $query->latest();
        }]);
        
        return view('blog.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = BlogCategory::orderBy('name')->get();
        return view('blog.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'blog_category_id' => 'required|exists:blog_categories,id',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'published_at' => 'nullable|date'
            ]);

            if ($request->hasFile('featured_image')) {
                if ($article->featured_image) {
                    Storage::disk('public')->delete($article->featured_image);
                }
                $path = $request->file('featured_image')->store('blog', 'public');
                $validated['featured_image'] = $path;
            }

            $article->update($validated);

            return redirect()->route('blog.articles.index')
                ->with('success', 'Artículo actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar artículo: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar el artículo: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        try {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            
            $article->delete();
            return redirect()->route('blog.articles.index')
                ->with('success', 'Artículo eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar artículo: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el artículo: ' . $e->getMessage());
        }
    }
}
