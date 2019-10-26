# Back-end Challenge Doc88

**Gerenciamento de pedidos de uma pastelaria**
###### Autor: *Anselmo Velame*.


*******
1. [Sobre o projeto](#about)
2. [Instalação](#install)
3. [Módulo Pastel](#products)
4. [Módulo Cliente](#customer)
3. [Módulo Pedido](#orders)

*******
<div id='about'/>

## Sobre o projeto<br>
* Foi implementado os cabeçalhos de solicitação HTTP(CORS) para não ter problemas com o "header" nas requisições do Front-end.
````
-> app/Http/Middleware/CorsMiddleware.php
-> app/Http/Kernel.php
````
* Como se trata de um projeto simples resolvir trabalhar com um conceito chamado de **Route Model Binding**;
* Parâmetros para consulta de um dado específico: $query->whereId($value)->orWhere('code', $value)->get();
* Consulta dos dados excluidos: Basta passar o parâmetro '?trashed=1';
 .
````
-> app/Providers/RouteServiceProvider.php
-> app/Traits/OnlyTrashed.php
````
* Aqui estão os responses **ResourcesJson/ResourcesCollection**, com os nomes dos campos que são realmente retornados aos usuários do aplicativo.  
````
-> app/Http/Resources/Api/
````
* A quantidade de fotos de cada pastel deixei como **opcional** adicionar mais de uma, sendo que a principal basta deixar o campo **capa=1**.
* Quanto ao upload das fotos podem ser em storage diferente do sistema. 
 ````
 Fotos Faker: ProductPhotosSeeder -> createPhotosModels
 Define Path: Models/ProductPhoto -> FILESYSTEM_DRIVER
 ````
 * Trait das exceptions personalizadas para api:  
 ````
 -> app/Exceptions/ExceptionTrait.php
 ````
 * Functions personalzadas:
 ````
 _Helpers/functions.php
 ````
 
<div id='install'/>

## Instalação: Via Composer (LAMP)<br>

* Clone ou faça o download do projeto.
 ````
 $ git clone https://github.com/avdesign/challenge-doc88.git
 ````
* Na pasta do projeto digite
````
$ composer update
 ````
* Crie um arquivo .env e copie e cole as variáveis do arquivo .env.example
````
$ touch .env
````
* Configure seu banco de dados.<br>
DB_DATABASE=challenge_doc88 <br>
DB_USERNAME=root  
DB_PASSWORD=secret

* Permissões de pastas e  link simbólico : 
````
$ chmod 777 -R stotage
$ php artisan stotage:link
````

* Para criar as tabelas e gerar as fotos dos pasteis digite os camandos: 
````
$ php artisan migrate --seed
$ php artisan serve
````
* Para testar o ambiente de desenvolvimento da API. use Postman ou similar.

<div id='products'/>

## Módulo Pastel<br>
* **LISTAR OS PASTEIS**<br>
    **method** : `GET`<br>
    **url** : `http://localhost:8000/api/products`<br>
    **paginate** : `http://localhost:8000/api/products?page=2` <br>
    **per page** : `5`
    
* **CONSULTAR UM PASTEL ESPECÍFICO**<br>
    **method** : `GET`<br>
    **parameters** : `id, slug ou código.`<br>
    **url** : `http://localhost:8000/api/products/parameter`
    
* **CONSULTAR UM PASTEL ESPECÍFICO**<br>
    **method** : `GET`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Content-Type: application/json`<br>
    **parameters** : `id, slug ou código do pastel.`<br>
    **url** : `http://localhost:8000/api/products/parameter` 
    
* **CONSULTAR FOTOS DE UM PASTEL ESPECÍFICO**<br>
    **method** : `GET`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Content-Type: application/json`<br>
    **parameters** : `id, slug ou código do pastel.`<br>
    **url** : `http://localhost:8000/api/products/parameter/photos`<br>
    
* **CONSULTAR UMA FOTO ESPECÍFICA**<br>
    **method** : `GET`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Content-Type: application/json`<br>
    **parameters** : `id, slug ou código do pastel.`<br>
    **id** : `id da foto`<br>
    **url** : `http://localhost:8000/api/products/parameter/photos/id`<br> 
    **return** : `Dados da foto e do pastel`<br> 
    
* **UPLOAD DAS FOTOS DE UM PASTEL ESPECÍFICO**<br>
    **method** : `POST`<br>
    **body** : `form-data`<br>
    **parameters** : `id, slug ou código do pastel.`<br>
    **url** : `http://localhost:8000/api/products/parameter/photos`<br> 
    **key** : `photos[]`<br> 
    **type** : `files`<br> 
         
         
 **Obs** : `Para ter acesso as fotod, não esquecer do camando:  php artisan storage:linl `<br>     
      
    
<div id='customer'/>

## Módulo Cliente<br>
* **LISTAR OS CLIENTES**<br>
    **method** : `GET`<br>
    **url** : `http://localhost:8000/api/customers`<br>
    **paginate** : `http://localhost:8000/api/customers?page=2` <br>
    **per page** : `5`
    
* **CADASTRO DE CLIENTE (JSON)**<br>
    **method** : `POST`<br>
    **url** : `http://localhost:8000/api/customers` <br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Content-Type: application/json`<br>
    **Execultar com os atributos abaixo** : 
````
    {        
        "name": "Anselmo Velame",
        "email": "design@anselmovelame.com.br",
        "phone": "(11)93209-2772",
        "address": "Rua Condessa Siciliano 27",
        "complement": "Ap. 05",
        "district": "Jd. São Paulo",
        "zipcode": "02044-050",
        "birth_date": "07/07/1962",
        "password": "secret"
    }
````
* **CONSULTAR UM CILENTE ESPECÍFICO**<br>
    **method** : `GET`<br>
    **parameters** : `códig ou id.`<br>
    **url** : `http://localhost:8000/api/customers/codigo`
    **excluidos** : `http://localhost:8000/api/customers/codigo?trashed=1`

* **ALTEAR CLIENTE (JSON)**<br>
    **method** : `PUT`<br>
    **url** : `http://localhost:8000/api/customers/code` <br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Content-Type: application/json`<br>
    **Execultar com os atributos abaixo** : 
````
    {   
        "code": "código do cliente",     
        "name": "Anselmo Velame",
        "email": "design@anselmovelame.com.br",
        "phone": "(11)93209-2772",
        "address": "Rua Condessa Siciliano 27",
        "complement": "Ap. 05",
        "district": "Jd. São Paulo",
        "zipcode": "02044-050",
        "birth_date": "07/07/1962",
        "password": "secret"
    }
````  
* **EXCLUSÃO DO CLIENTE**<br>
    **method** : `PATCH`<br>
    **url** : `http://localhost:8000/api/customers/code` <br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Content-Type: application/json`<br> 
    
* **RESTAURAR UM CILENTE ESPECÍFICO**<br>
    **method** : `PATCH`<br>
    **url** : `http://localhost:8000/api/customers/code` <br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Content-Type: application/json`<br>
    
    
<div id='orders'/>

## Módulo Pedido<br>


## Instalação: Docker (NGINX)<br>
* em desenvolvimento

 
 
 
 