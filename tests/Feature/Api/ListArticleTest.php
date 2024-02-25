<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
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
            $token = $user->createToken('test-token')->plainTextToken; // Creamos un token
            
           

            $url =Route('api.v1.articles.show', $article);
            $response = $this->getJson($url, ['Authorization' => $token,  //pasamos las cabeceras 'accept y Authorization
            'Accept' => "application/vnd.api+json"]);
    
            
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

      /**
     * @return void
     * @test
     */
    public function can_fetch_all_articles():void
    {
        $this->withoutExceptionHandling();

        $articles = Article::factory()->count(3)->create();

        $response = $this->getJson(route('api.v1.articles.index'), ['Accept' => "application/vnd.api+json"]);

        $response->assertJson([
            'data' => [
                [
                    'type' => 'articles',
                    'id' => (string) $articles[0]->getRouteKey(),
                    'attributes' => [
                        'title' => $articles[0]->title,
                        'slug' => $articles[0]->slug,
                        'content' => $articles[0]->content,
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $articles[0])
                    ]
                ],
                [
                    'type' => 'articles',
                    'id' => (string) $articles[1]->getRouteKey(),
                    'attributes' => [
                        'title' => $articles[1]->title,
                        'slug' => $articles[1]->slug,
                        'content' => $articles[1]->content,
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $articles[1])
                    ]
                ],
                [
                    'type' => 'articles',
                    'id' => (string)$articles[2]->getRouteKey(),
                    'attributes' => [
                        'title' => $articles[2]->title,
                        'slug' => $articles[2]->slug,
                        'content' => $articles[2]->content,
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $articles[2])
                    ]
                ]
            ],
            'links' => [
            'self' => route('api.v1.articles.index')
            ]
        ]);
    }
}
