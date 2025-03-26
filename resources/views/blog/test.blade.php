@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Test Blog</div>

                <div class="card-body">
                    <p>Esta es una vista de prueba para el blog.</p>
                    <a href="{{ route('blog.categories.index') }}" class="btn btn-primary">
                        Ir a Categorías del Blog
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 