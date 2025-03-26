@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    @if($article->featured_image)
                        <img src="{{ $article->featured_image_url }}" 
                             class="img-fluid rounded mb-4" 
                             alt="{{ $article->title }}">
                    @endif

                    <h1 class="mb-3">{{ $article->title }}</h1>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="text-muted">
                            <small>
                                @if($article->published_at)
                                    Publicado: {{ $article->published_at->format('d/m/Y H:i') }} | 
                                @else
                                    Fecha: {{ $article->created_at->format('d/m/Y H:i') }} | 
                                @endif
                                Categoría: {{ $article->category->name }}
                            </small>
                        </div>
                        @if(auth()->id() === $article->author_id)
                            <div class="btn-group">
                                <a href="{{ route('blog.articles.edit', $article) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('blog.articles.destroy', $article) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Está seguro?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="article-content mb-4">
                        {{ $article->content }}
                    </div>
                </div>
            </div>

            <!-- Sección de Comentarios -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Comentarios</h5>
                </div>
                <div class="card-body">
                    <!-- Mensajes de alerta -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error') && !session('success'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Formulario de Comentarios -->
                    <form action="{{ route('blog.articles.comments.store', $article) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Nombre</label>
                            <input type="text" 
                                   class="form-control @error('user_name') is-invalid @enderror" 
                                   id="user_name" 
                                   name="user_name" 
                                   value="{{ old('user_name') }}" 
                                   required>
                            @error('user_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Comentario</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="3" 
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Publicar Comentario</button>
                    </form>

                    <!-- Lista de Comentarios -->
                    @if($article->comments->isEmpty())
                        <div class="alert alert-info">
                            No hay comentarios aún. ¡Sé el primero en comentar!
                        </div>
                    @else
                        <div class="comments-list">
                            @foreach($article->comments as $comment)
                                <div class="comment border-bottom pb-3 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="mb-1">{{ $comment->user_name }}</h6>
                                            <small class="text-muted">
                                                {{ $comment->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                        @if(auth()->id() === $article->author_id)
                                            <form action="{{ route('blog.comments.destroy', $comment) }}" 
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('¿Está seguro?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <p class="mb-0 mt-2">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 