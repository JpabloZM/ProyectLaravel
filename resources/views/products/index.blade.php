@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-box me-2"></i>{{ __('shop.product_list') }}</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('shop.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i>{{ __('shop.create_product') }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('shop.products.index') }}" method="GET" class="d-flex">
                <select name="category" class="form-select me-2">
                    <option value="">{{ __('shop.all_categories') }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline-secondary">{{ __('shop.filter') }}</button>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ $product->name }}</h5>
                        <span class="badge bg-primary">{{ $product->category->name }}</span>
                    </div>
                    
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             class="card-img-top p-2" 
                             alt="{{ $product->name }}" 
                             style="height: 200px; object-fit: contain;">
                    @else
                        <div class="text-center p-4 bg-light">
                            <i class="fas fa-image fa-5x text-secondary"></i>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="text-primary">${{ number_format($product->price, 2) }}</h5>
                            <span class="badge {{ $product->isLowStock() ? 'bg-danger' : 'bg-success' }}">
                                {{ $product->stock }} {{ __('shop.units') }}
                            </span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('shop.products.show', $product) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('shop.products.edit', $product) }}" class="btn btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('shop.products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" 
                                   onclick="return confirm('{{ __('shop.confirm_delete') }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    {{ __('shop.no_products_found') }}
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection 