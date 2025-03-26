@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h1 class="display-4 text-center mb-4">{{ __('general.welcome') }}</h1>
                    
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <div class="card mb-4 h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h3 class="card-title"><i class="fas fa-store me-2 text-primary"></i>{{ __('general.shop') }}</h3>
                                    <p class="card-text">{{ __('Gestiona el inventario de tu tienda. Añade, edita y elimina productos y categorías.') }}</p>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('shop.products.index') }}" class="btn btn-primary">{{ __('shop.products') }}</a>
                                        <a href="{{ route('shop.categories.index') }}" class="btn btn-outline-primary">{{ __('shop.categories') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="card mb-4 h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h3 class="card-title"><i class="fas fa-blog me-2 text-success"></i>{{ __('general.blog') }}</h3>
                                    <p class="card-text">{{ __('Gestiona el contenido de tu blog. Publica artículos y organiza sus categorías.') }}</p>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('blog.articles.index') }}" class="btn btn-success">{{ __('blog.articles') }}</a>
                                        <a href="{{ route('blog.categories.index') }}" class="btn btn-outline-success">{{ __('blog.categories') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card border-0 bg-light shadow-sm">
                                <div class="card-body p-4">
                                    <h3 class="card-title text-center mb-3"><i class="fas fa-info-circle me-2 text-info"></i>{{ __('general.about_project') }}</h3>
                                    <p class="card-text">
                                        {{ __('Este proyecto evaluativo de Laravel incluye dos secciones principales:') }}
                                    </p>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h5><i class="fas fa-store text-primary me-2"></i>{{ __('general.shop_module') }}</h5>
                                            <ul class="list-group list-group-flush mb-3">
                                                <li class="list-group-item bg-light">{{ __('Gestión completa de productos (CRUD)') }}</li>
                                                <li class="list-group-item bg-light">{{ __('Gestión de categorías de productos') }}</li>
                                                <li class="list-group-item bg-light">{{ __('Subida y manejo de imágenes') }}</li>
                                                <li class="list-group-item bg-light">{{ __('Sistema de alertas para stock bajo') }}</li>
                    </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h5><i class="fas fa-blog text-success me-2"></i>{{ __('general.blog_module') }}</h5>
                                            <ul class="list-group list-group-flush mb-3">
                                                <li class="list-group-item bg-light">{{ __('Gestión de artículos') }}</li>
                                                <li class="list-group-item bg-light">{{ __('Gestión de categorías de blog') }}</li>
                                                <li class="list-group-item bg-light">{{ __('Sistema de comentarios') }}</li>
                                                <li class="list-group-item bg-light">{{ __('Visualización de contenido') }}</li>
                    </ul>
                </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <h5 class="text-center"><i class="fas fa-cogs text-info me-2"></i>{{ __('general.global_features') }}</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <li class="list-group-item bg-light">{{ __('Menú de navegación utilizando request->routeIs() para marcar la sección activa') }}</li>
                                            <li class="list-group-item bg-light">{{ __('Implementación de traducciones para ambas secciones (e-commerce y blog)') }}</li>
                                            <li class="list-group-item bg-light">{{ __('Validación de formularios mediante Form Requests') }}</li>
                                            <li class="list-group-item bg-light">{{ __('Implementación de Route Model Binding en todas las rutas donde se trabaje con modelos') }}</li>
                                            <li class="list-group-item bg-light">{{ __('Diseño responsive utilizando Bootstrap') }}</li>
                                        </ul>
                                    </div>
                                    
                                    <p class="card-text text-center">
                                        <small class="text-muted">{{ __('Desarrollado con Laravel') }} {{ app()->version() }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
