<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth:sanctum', [
            'only' => ['show', 'store', 'update', 'destroy']
        ]);
    } */
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::query()
        ->allowedSorts(['title', 'content'])
        ->jsonPaginate();

        return ArticleResource::collection($articles); //SE HACE UNA COLECCIÓN DE TODOS LOS RESOURCES DE TODOS LOS ARTÍCULOS
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // EN API NO HAY CREATE
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request):ArticleResource
    {
        $article= Article::create([   // SE PASAN LOS DATOS DE LOS ATRIBUTOS EN UN ARRAY
            'title' => $request->input('data.attributes.title'),
            'slug' => $request->input('data.attributes.slug'),      // POR ESTO DEBEMOS MANDAR UNA PETICIÓN CON DATA Y ATTRIBUTES
            'content' => $request->input('data.attributes.content')
        ]);

        return ArticleResource::make($article); // DEBEMOS MODIFICAR ARTICLE RESOURCE PARA QUE DEVUELVA EL HEADER LOCATION

        // SI LO HACEMOS ASÍ Y TENEMOS RELACIONES NO FUNCIONARÁ COMENTAR EN MIGRACIÓN
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return ArticleResource::make($article);
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
    public function update(ArticleRequest $request, Article $article)
    {
        $article->update([
            'title' => $request->input('data.attributes.title'),
            'slug' => $request->input('data.attributes.slug'),
            'content' => $request->input('data.attributes.content'),

        ]);
        return ArticleResource::make($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json([
            "success" => "Article ".$article->id." was deleted successfully"
        ]);
        
    }
}
