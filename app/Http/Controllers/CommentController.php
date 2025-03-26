<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\NewCommentNotification;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Article $article)
    {
        try {
            $validated = $request->validate([
                'content' => 'required|string',
                'user_name' => 'required|string|max:255',
                'email' => 'required|email|max:255'
            ]);

            $comment = $article->comments()->create($validated);
            Log::info('Comentario creado con éxito: ID ' . $comment->id);

            // Intentar enviar notificación al autor del artículo si existe
            try {
                if ($article->author) {
                    Mail::to($article->author->email)
                        ->send(new NewCommentNotification($article, $comment));
                    Log::info('Notificación de comentario enviada al autor');
                } else {
                    Log::warning('No se envió notificación porque el artículo no tiene autor');
                }
            } catch (\Exception $mailError) {
                Log::error('Error al enviar correo de notificación: ' . $mailError->getMessage());
                // No detenemos el flujo, solo registramos el error
            }

            return back()->with('success', 'Comentario publicado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear comentario: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al publicar el comentario: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        try {
            $articleId = $comment->article_id;
            $comment->delete();
            Log::info('Comentario eliminado con éxito: ID ' . $comment->id);
            
            return back()->with('success', 'Comentario eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar comentario: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el comentario: ' . $e->getMessage());
        }
    }
}
