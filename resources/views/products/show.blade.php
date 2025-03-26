@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detalles del Producto</h5>
                    <a href="{{ route('shop.products.index') }}" class="btn btn-secondary">Volver</a>
                </div>

                <div class="card-body">
                    @if($product->image)
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                class="img-fluid rounded" 
                                style="max-height: 300px;">
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Nombre:</div>
                        <div class="col-md-9">{{ $product->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Descripción:</div>
                        <div class="col-md-9">{{ $product->description }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Precio:</div>
                        <div class="col-md-9">${{ number_format($product->price, 2) }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Stock:</div>
                        <div class="col-md-9">
                            <span class="badge {{ $product->isLowStock() ? 'bg-danger' : 'bg-success' }}">
                                {{ $product->stock }} unidades
                            </span>
                            @if($product->isLowStock())
                                <div class="text-danger mt-1">
                                    <small><i class="fas fa-exclamation-triangle me-1"></i>Stock bajo. Considere reabastecer pronto.</small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 fw-bold">Categoría:</div>
                        <div class="col-md-9">{{ $product->category->name }}</div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('shop.products.edit', $product) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 