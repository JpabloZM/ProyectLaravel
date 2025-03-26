@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-4">
            <h2>Artículos del Blog</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('blog.articles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Nuevo Artículo
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

    @if($articles->isEmpty())
        <div class="alert alert-info">
            No hay artículos publicados.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($articles as $article)
                <div class="col">
                    <div class="card h-100">
                        @if($article->featured_image)
                            <img src="{{ $article->featured_image_url }}" 
                                 class="card-img-top" 
                                 alt="{{ $article->title }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="fas fa-image text-muted fa-3x"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text text-muted small">
                                @if($article->published_at)
                                    Publicado: {{ $article->published_at->format('d/m/Y') }}
                                @else
                                    Fecha: {{ $article->created_at->format('d/m/Y') }}
                                @endif
                            </p>
                            <p class="card-text">{{ Str::limit($article->content, 150) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary">{{ $article->category->name }}</span>
                                <a href="{{ route('blog.articles.show', $article) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    Leer más
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection 