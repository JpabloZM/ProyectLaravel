@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-4">
            <h2>Categorías</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('shop.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Nueva Categoría
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="alert alert-info">
            No se encontraron categorías.
        </div>
    @else
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text">{{ Str::limit($category->description, 100) }}</p>
                            
                            @if($category->product_count > 0)
                                <span class="badge bg-info mb-2">
                                    {{ $category->product_count }} productos
                                </span>
                            @else
                                <span class="badge bg-secondary mb-2">
                                    Sin productos
                                </span>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('shop.categories.edit', $category) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('shop.categories.destroy', $category) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="return confirm('¿Está seguro? Esto no eliminará los productos asociados.')">
                                        <i class="fas fa-trash"></i> Eliminar
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
        {{ $categories->links() }}
    </div>
</div>
@endsection 