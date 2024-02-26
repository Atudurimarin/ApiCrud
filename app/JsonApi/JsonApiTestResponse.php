<?php

namespace App\JsonApi;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\InvalidArgumentException;

class JsonApiTestResponse
{
   

    public function assertJsonApiResource(): Closure
    {
        return function ($model, $attributes) {  //USADO EN CreateArticlesTest
            /** @var TestResponse $this */

            return $this->assertJson([
                'data' => [
                    'type' => 'articles',
                    'id' => (string) $model->getRouteKey(),
                    'attributes' => $attributes,
                    'links' => [
                        'self' => route('api.v1.articles.show', $model)
                    ]
                ]
                    ])->assertHeader('Location',route('api.v1.articles.show', $model));
        };
    }

  

    public function assertJsonApiResourceCollection(): Closure
    {
        return function ($models, $attributesKeys) { // USADO en can_fetch_all_articles_test
            /** @var TestResponse $this */       

            $this->assertJsonStructure([             
                'data' => [
                    '*' => [
                        'attributes' => $attributesKeys
                    ]
                ]
            ]);

            foreach ($models as $model) {
                $this->assertJsonFragment([
                    'type' => 'articles',
                    'id' => (string) $model->getRouteKey(),
                    'links' => [
                        'self' => route('api.v1.articles.show', $model)
                    ]
                ]);
            }

            return $this;
        };
    }
}
