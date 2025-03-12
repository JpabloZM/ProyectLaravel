@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detalles del Producto</h5>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver</a>
                </div>

                <div class="card-body">
                    @if($product->image)
                        <div class="text-center mb-4">
                            <img src="{{ Storage::url($product->image) }}" 
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
                            <span class="{{ $product->stock < 5 ? 'text-danger' : '' }}">
                                {{ $product->stock }} unidades
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Categoría:</div>
                        <div class="col-md-9">{{ $product->category->name }}</div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                            Editar Producto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 