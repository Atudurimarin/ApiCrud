<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
use Tests\MakesJsonApiRequests;
use Tests\TestCase;


class ListArticleTest extends TestCase
{
    use RefreshDatabase;
   
    /** @test */

    public function can_fetch_a_single_article_test(): void
    {
        
            //Deshabilitamos el manejo de excepciones para que nos dé un detalle mayor
            $this->withoutExceptionHandling();

            $article = Article::factory()->create(); // creamos un artículo
            $user = User::factory()->create();   // creamos un usuario
            //$token = $user->createToken('test-token')->plainTextToken; // Creamos un token
            Sanctum::actingAs($user);
           

            $url =Route('api.v1.articles.show', $article);
            $response = $this->getJson($url);
            //, ['Authorization' => $token,  //pasamos las cabeceras 'accept y Authorization
            //'Accept' => "application/vnd.api+json"]);
    
            
            $response->assertExactJson([
                'data' => [
                    'type' => 'articles',
                    'id' => (string)$article->getRouteKey(),
                    'attributes' => [
                        'title' => $article->title,
                        'slug' => $article->slug,
                        'content' => $article->content
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $article)
                    ],
                ],
            ]);

            
    }

    /** @test */
    public function can_fetch_all_articles()
    {
        $articles = Article::factory()->count(3)->create();

        $response = $this->getJson(route('api.v1.articles.index'));

        $response->assertJsonApiResourceCollection($articles, [
            'title', 'slug', 'content'
        ]);
  }

  

    /** @test */  
    /*   TODAVÍA NO FUNCIONA --> CREAR ERRORES
    public function it_returns_a_json_api_error_object_when_an_article_is_not_found()
    {
        $this->getJson(route('api.v1.articles.show', 'not-existing'))
            ->assertJsonApiError(
                title: "Not Found",
                detail: "No records found with the id 'not-existing' in the 'articles' resource.",
                status: "404"
            );
    } */ 
}





