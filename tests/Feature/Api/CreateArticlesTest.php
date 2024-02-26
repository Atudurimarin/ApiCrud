<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateArticlesTest extends TestCase
{
    use RefreshDatabase;
   
      /** @test */
      public function can_create_articles()
      {
          $user = User::factory()->create();
  
         
  
          Sanctum::actingAs($user);
  
          $response = $this->postJson(route('api.v1.articles.store'), [
              'title' => 'Nuevo artículo',
              'slug' => 'nuevo-articulo',
              'content' => 'Contenido del artículo'
          ])->assertCreated();
  
          $article = Article::first();
  
          $response->assertJsonApiResource($article, [
              'title' => 'Nuevo artículo',
              'slug' => 'nuevo-articulo',
              'content' => 'Contenido del artículo'
          ]);
  
          $this->assertDatabaseHas('articles', [
              'title' => 'Nuevo artículo',
          ]);
      }
}
