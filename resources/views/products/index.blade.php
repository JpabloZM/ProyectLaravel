@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-4">
            <h2>Productos</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Nuevo Producto
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                <select name="category" class="form-select me-2">
                    <option value="">Todas las categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-filter me-1"></i>Filtrar
                </button>
                @if(request('category'))
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-times me-1"></i>Limpiar
                    </a>
                @endif
            </form>
        </div>
    </div>

    @if($products->isEmpty())
        <div class="alert alert-info">
            No se encontraron productos{{ request('category') ? ' en esta categoría' : '' }}.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($products as $product)
                <div class="col d-flex justify-content-center">
                    <div class="card h-100" style="width: 280px;">
                        <div class="card-img-container">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}">
                            @else
                                <div class="no-image-placeholder">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                            <p class="card-text small text-muted mb-2" style="height: 3em; overflow: hidden;">
                                {{ Str::limit($product->description, 50) }}
                            </p>
                            <p class="card-text mb-1">
                                <small class="text-muted d-block">Categoría: {{ $product->category->name }}</small>
                                <strong class="d-block">${{ number_format($product->price, 2) }}</strong>
                                <span class="badge {{ $product->stock < 5 ? 'bg-danger' : 'bg-success' }}">
                                    Stock: {{ $product->stock }}
                                </span>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2 justify-content-between">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-info btn-sm flex-grow-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning btn-sm flex-grow-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('¿Está seguro?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card-img-container {
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    .card-img-container img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 8px;
    }
    .no-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .no-image-placeholder i {
        font-size: 3rem;
        opacity: 0.5;
    }
</style>
@endsection 