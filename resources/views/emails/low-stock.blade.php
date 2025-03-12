@component('mail::message')
# Alerta de Stock Bajo

El producto **{{ $product->name }}** tiene un stock bajo ({{ $product->stock }} unidades).

Detalles del producto:
- Precio: ${{ number_format($product->price, 2) }}
- Categoría: {{ $product->category->name }}

@component('mail::button', ['url' => route('products.edit', $product)])
Gestionar Producto
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent 