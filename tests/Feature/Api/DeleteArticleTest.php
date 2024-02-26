<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */ /*
    public function guests_cannot_delete_articles()
    {
        $article = Article::factory()->create();

        $this->deleteJson(route('api.v1.articles.destroy', $article))
            ->assertUnauthorized();
    } */

    /** @test */
    public function can_delete_articles()
    {
        $article = Article::factory()->create();
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->deleteJson(route('api.v1.articles.destroy', $article));
           

        $this->assertDatabaseCount('articles', 0);
    }
}
