@component('mail::message')
# Nuevo Comentario en tu Artículo

Has recibido un nuevo comentario en tu artículo "{{ $article->title }}".

**Detalles del comentario:**
- Autor: {{ $comment->user_name }}
- Email: {{ $comment->email }}
- Contenido: {{ $comment->content }}

@component('mail::button', ['url' => route('blog.articles.show', $article)])
Ver Artículo
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent 