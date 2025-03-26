@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-4">
            <h2>Categorías del Blog</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('blog.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Nueva Categoría
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($categories->isEmpty())
                <div class="alert alert-info">
                    No hay categorías registradas.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Artículos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ Str::limit($category->description, 50) }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $category->articles_count }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('blog.categories.edit', $category) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('blog.categories.destroy', $category) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('¿Está seguro?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection 