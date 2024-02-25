## 1- PREPARAR BBDD EN .ENV
    1.1 - Descomentar líneas de test en memoria en phpunit.xml

## 2- CREAR MODELOS Y MIGRACIONES  ** php artisan make:model Article -mcr
    2.1 - Configurar Modelo -> protected $guarded [] + relaciones NO!!UEE
    2.1 - Configurar migración -> Añadir los campos $table->string('title')
    2.2 - Crear Seeders y Factories
        - factory: 
            return [
                'title' => $this->faker->sentence(4),
                'slug' => $this->faker->slug,
                'content' => $this->faker->paragraphs(3, true),
            ];
    2.3 - INSTALAMOS SANCTUM
    2.4 - composer require laravel/sanctum
        - php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
        - php artisan migrate

## 3- CREAR ARTICLE CONTROLADOR --resource (si no lo hemos creado con el modelo)
    3.1 - implementar métodos
    3.2 - Crear Article Resource  ** php artisan make:resource ArticleResource ** -> añadir estructura sin 'data'
    3.3 - Crear Article Collection ** php artisan make:resource ArticleCollection ** añadir link

## 4- CREAR RUTA apiResource (si no está creada con el resource)
    4.1 - configurar prefijo -> app>providers>RouteServiceProvider -> ->prefix('api/v1') <-> se añade v1
    4.2 - Route::apiResource('articles', ArticleController::class)->names('api.v1.articles);

## 5- CREAR AUTH CONTROLADOR
    5.2 - Crear el AuthController
    5.3 - Crear el método register + -> Crear Ruta
    5.4 - Crear el método login + -> Crear Ruta
    5.5 - Crear el método logout + -> Crear Ruta
    5.6 - Modificar Constructor del ArticleController:
        -    public function __construct()
    {
        $this->middleware('auth:sanctum', [
            'only' => ['store', 'update', 'destroy']  <-> para requerir token
        ]);
    }
    7.7- Usar middleware auth:sanctum para ruta logout


## 6- CREAR MIDDLEWARE PARA VALIDAR CABECERAS
    6.1 - Rellenar middleware con el código
    6.2 - Dar de alta en el Kernel en todas las rutas api


## 7- CREAR ARTICLEREQUEST PARA VALIDAR DATOS
    7.1 - Cuando se usa un ArticleRequest que se ha usado para validar creación obligará a rellenar todos los campos y a enviarlo con las estructura apijson (data)


## 8- CREAR MIXINS PARA EXTENDER BUILDER Y TESTRESPONSE
    8.1 - Crear App/JsonApi/JasonApiQueryBuilder.php ->meter código de los mixins (carpeta creada JsonApi)
    8.2 - Crear Provider JsonApiServiceProvider.php
        - Dar de alta el provider en App > config > app.php
        - Dar de alta el mixin en el boot:
            Builder::mixin(new JsonApiQueryBuilder());
    8.3 - Modificar Controller para aceptar ordenación y paginación
                 $articles = Article::query()
           
                    ->allowedSorts(['title', 'content'])
                    ->jsonPaginate();

    8.4 - si el parámetro del mixin es page.size -> en la url deberemos poner page[size]=5

## 9- PROTEGER RUTAS CON EL MIDDLEWARE AUTH:SANCTUM
    9.1 - Group Middleware -> para proteger rutas ->except('index')->names->('api.v1.articles');
    9.2 - crear ruta index fuera del group


## 10 - PUBLICAR STUBS PARA EMPEZAR A HACER LOS TESTS
    10.1 - ** php artisan stub:publish **
    10.2- ir a carpeta stubs y borrar todos los stubs menos test.stub y test.unit.stub
    10.3- modificamos test.stub :
        10.3.1- Añadimos la línea: <-> use RefreshDatabase;
        10.3.2- Cambiamos la línea de comentario documentación por /** @test */
        10.3.3- Borramos contenido de la función, comentamos y salimos


## 11- CREAR LOS TESTS
    11.1 - $this->withoutExceptionHandling();                           - MANEJAR ERRORES -
    11.2 - $article = Article::factory()->create();                     - CREAR ARTÍCULO -
    11.3 - $user = User::factory()->create;                             - CREAR UN USUARIO -
    11.4 - $token = $user->createToken('test-token')->plainTextToken;   - CREAR UN TOKEN -
    11.3 - $response = $this->getJson(route('api.v1.articles.show', $article), [AÑADIR CABECERAS NECESARIAS]);
