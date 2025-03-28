<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'nullable'
            ]);

            $category = Category::create($validated);

            return redirect()->route('shop.categories.index')
                ->with('success', 'Categoría creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear categoría: ' . $e->getMessage());
            return back()->with('error', 'Error al crear la categoría. Por favor, intente nuevamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'nullable'
            ]);

            $category->update($validated);

            return redirect()->route('shop.categories.index')
                ->with('success', 'Categoría actualizada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar categoría: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar la categoría. Por favor, intente nuevamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            if ($category->products()->exists()) {
                return back()->withErrors(['error' => 'No se puede eliminar una categoría que tiene productos asociados']);
            }
            
            $category->delete();
            return redirect()->route('shop.categories.index')
                ->with('success', 'Categoría eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la categoría. Por favor, intente nuevamente.');
        }
    }
}
