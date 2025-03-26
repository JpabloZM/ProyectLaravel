<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::withCount('articles')->orderBy('name')->paginate(10);
        return view('blog.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            BlogCategory::create($validated);

            return redirect()->route('blog.categories.index')
                ->with('success', 'Categoría creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear categoría: ' . $e->getMessage());
            return back()->with('error', 'Error al crear la categoría. Por favor, intente nuevamente.');
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
    public function edit(BlogCategory $category)
    {
        return view('blog.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $category->update($validated);

            return redirect()->route('blog.categories.index')
                ->with('success', 'Categoría actualizada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar categoría: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar la categoría. Por favor, intente nuevamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $category)
    {
        try {
            if ($category->articles()->exists()) {
                return back()->with('error', 'No se puede eliminar una categoría que tiene artículos.');
            }
            
            $category->delete();
            return redirect()->route('blog.categories.index')
                ->with('success', 'Categoría eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la categoría. Por favor, intente nuevamente.');
        }
    }
}
