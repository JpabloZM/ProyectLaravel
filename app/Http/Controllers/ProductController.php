<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\LowStockNotification;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        $products = $query->latest()->paginate(10);
        $categories = Category::orderBy('name')->get();
        
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0|max:99999999.99',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ], [
                'price.max' => 'El precio no puede ser mayor a $99,999,999.99'
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Asegurar que el directorio exista
                $storage_path = storage_path('app/public/products');
                if (!file_exists($storage_path)) {
                    mkdir($storage_path, 0755, true);
                }
                
                // Guardar el archivo
                $file->move($storage_path, $filename);
                $validated['image'] = 'products/' . $filename;
                
                Log::info('Imagen guardada en: ' . $storage_path . '/' . $filename);
            }

            $product = Product::create($validated);

            if ($product->isLowStock()) {
                Log::warning("Producto {$product->name} tiene bajo stock: {$product->stock} unidades");
            }

            return redirect()->route('shop.products.index')
                ->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear producto: ' . $e->getMessage());
            return back()->with('error', 'Error al crear el producto. Por favor, intente nuevamente.');
        }
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0|max:99999999.99',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ], [
                'price.max' => 'El precio no puede ser mayor a $99,999,999.99'
            ]);

            if ($request->hasFile('image')) {
                if ($product->image) {
                    $old_path = storage_path('app/public/' . $product->image);
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }
                
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Asegurar que el directorio exista
                $storage_path = storage_path('app/public/products');
                if (!file_exists($storage_path)) {
                    mkdir($storage_path, 0755, true);
                }
                
                // Guardar el archivo
                $file->move($storage_path, $filename);
                $validated['image'] = 'products/' . $filename;
                
                Log::info('Imagen guardada en: ' . $storage_path . '/' . $filename);
            }

            $product->update($validated);

            if ($product->isLowStock()) {
                Log::warning("Producto {$product->name} tiene bajo stock: {$product->stock} unidades");
            }

            return redirect()->route('shop.products.index')
                ->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar producto: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el producto. Por favor, intente nuevamente.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->image) {
                $old_path = storage_path('app/public/' . $product->image);
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }
            $product->delete();
            return redirect()->route('shop.products.index')
                ->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar producto: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el producto. Por favor, intente nuevamente.');
        }
    }
}
