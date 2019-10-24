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
* Como alterar os parametros de busca.
````
-> app/Providers/RouteServiceProvider.php
````
* Para não inflar as respostas em JSON e como não é aconselhado o retorno com os mesmos nomes dos campos do banco de dados , criei os Resources/ResourcesCollection com os nomes dos campos que são realmente retornadas aos usuários do aplicativo.  
````
-> app/Http/Resources/Api/
````
* Através da variável URL_PHOTOS localizada no arquivo .env, você poderá alterar o nome da url das fotos caso seja necessário.
 ````
 URL_PHOTOS=http://localhost:8000
 ````
<div id='install'/>

## Instalação com o Composer<br>

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
    **url** : `http://localhost:8000/api/products/slug`
    
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
    **parameters** : `código.`<br>
    **url** : `http://localhost:8000/api/customers/codigo`


<div id='orders'/>

## Módulo Pedido<br>


## Instalação Docker com NGINX<br>
* em desenvolvimento

 
 
 
 