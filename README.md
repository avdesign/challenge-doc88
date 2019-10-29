# Back-end Challenge Doc88

**Gerenciamento de pedidos de uma pastelaria**
###### Autor: *Anselmo Velame*.


*******
1. [Sobre o projeto](#about)
2. [Instalação](#install)
3. [Módulo Pastel](#products)
4. [Módulo Cliente](#customer)
5. [Módulo Pedido](#orders)
6. [Disparo de E-mails](#mails)
7. [Relatórios](#reports)
*******
<div id='about'/>

## Sobre o projeto<br>
* Geralmente não é uma boa prática deixar lógica de negócios na camada dos controllers, neste desafio mostra alguns exemplos de aplicação RESTFul e como deixar a lógica de negócios nos Models e nos Repositories. Tudo vai depender da complexidade do projeto, em projetos mais complexos sempre uso os Repositories, consequentemente deixo a vida dos Controllers e Models mais simples, já que eles não serão mais os responsáveis por manter essas lógicas.
````
-> app/Repositories
-> app/Models
````  
* Partindo do princípio de que arquivos json mal formulados pode ser um desperdício de recursos, a idéia foi explorar os ResourcesJson/ResourcesCollection com os nomes dos campos que são realmente retornados aos desenvolvedores de aplicativos.
````
-> app/Http/Resources/Api/
````

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
* **ADICIONAR PASTEL**<br>
    **method** : `POST`<br>
    **body** : `form-data`<br>
    **url** : `http://localhost:8000/api/products`<br>
    **input text** : `name` <br>
    **input text** : `code` <br>
    **input text** : `price` <br>
    **input file** : `photo` <br>    
    
* **LISTAR OS PASTEIS**<br>
    **method** : `GET`<br>
    **url** : `http://localhost:8000/api/products`<br>
    **paginate** : `http://localhost:8000/api/products?page=2` <br>
    **per page** : `5`
    
* **CONSULTAR UM PASTEL ESPECÍFICO**<br>
    **method** : `GET`<br>
    **parameter** : `id, slug ou código.`<br>
    **url** : `http://localhost:8000/api/products/parameter`
    
* **EDITAR UM PASTEL ESPECÍFICO**<br>
    **method** : `POST`<br>
    **body** : `form-data`<br>
    **parameter** : `id, slug ou código do pastel.`<br>    
    **url** : `http://localhost:8000/api/products/parameter` <br>
    **_method text** : `PUT` <br>
    **input text** : `name` <br>
    **input text** : `code` <br>
    **input text** : `price` <br>
    
* **EXCLUIR UM PASTEL**<br>
    **method** : `DELETE`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
    **parameter** : `id, slug ou código do pastel.`<br>    
    **url** : `http://localhost:8000/api/products/parameter` <br>
    
* **RESTAURAR UM PASTEL**<br>
    **method** : `PATCH`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
    **parameter** : `id, slug ou código do pastel.`<br>    
    **url** : `http://localhost:8000/api/products/parameter/restore?trashed=1` <br>
    
    
* **CONSULTAR FOTOS DE UM PASTEL ESPECÍFICO**<br>
    **method** : `GET`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
    **parameter** : `id, slug ou código do pastel.`<br>
    **url** : `http://localhost:8000/api/products/parameter/photos`<br>
    
* **CONSULTAR UMA FOTO ESPECÍFICA**<br>
    **method** : `GET`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
    **parameter** : `id, slug ou código do pastel.`<br>
    **id** : `id da foto`<br>
    **url** : `http://localhost:8000/api/products/parameter/photos/id`<br> 
    **return** : `Dados da foto e do pastel`<br> 
    
* **UPLOAD DAS FOTOS (MULTIPLE)**<br>
    **method** : `POST`<br>
    **body** : `form-data`<br>
    **parameter** : `id, slug ou código do pastel.`<br>
    **url** : `http://localhost:8000/api/products/parameter/photos`<br>
    **input file** : `photos[]` <br>
    **input file** : `photos[] -> adicione quantas fotos quiser` <br>
    
    
* **ALTERAR FOTO**<br>
    **method** : `POST`<br>
    **body** : `form-data`<br>
    **parameter** : `id, slug ou código do pastel.`<br>
    **id** : `id da foto`<br>
    **url** : `http://localhost:8000/api/products/parameter/photos/id`<br>
    **input file** : `photo` <br>
    **_method text** : `PUT` <br>
    **cover text** : `1 -> Foto capa` <br>
    
* **REMOVER FOTO**<br>
    **method** : `DELETE`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
    **parameter** : `id, slug ou código do pastel.`<br>
    **id** : `id da foto`<br>
    **url** : `http://localhost:8000/api/products/parameter/photos/id`<br>
    
 **Obs** : `Para ter acesso as fotos não esquecer do camando:  php artisan storage:link `<br>     
      
    
<div id='customer'/>

## Módulo Cliente<br>
* **LISTAR OS CLIENTES**<br>
    **method** : `GET`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
    **headers**  `Content-Type: application/json`<br>
    **url** : `http://localhost:8000/api/customers`<br>
    **paginate** : `http://localhost:8000/api/customers?page=2` <br>
    **per page** : `5`
    
* **CADASTRO DE CLIENTE (JSON)**<br>
    **method** : `POST`<br>
    **url** : `http://localhost:8000/api/customers` <br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
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
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
    **parameter** : `código ou id.`<br>
    **url** : `http://localhost:8000/api/customers/codigo`<br>
    **excluidos** : `http://localhost:8000/api/customers/parameter?trashed=1`<br>

* **ALTEAR CLIENTE (JSON)**<br>
    **method** : `PUT`<br>
    **parameter** : `código ou id.`<br>
    **url** : `http://localhost:8000/api/customers/parameter` <br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
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
    **method** : `DELETE`<br>
    **parameter** : `código ou id.`<br>
    **url** : `http://localhost:8000/api/customers/parameter` <br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br> 
    
    
* **RESTAURAR UM CILENTE**<br>
    **method** : `PATCH`<br>
    **parameter** : `código ou id.`<br>
    **url** : `http://localhost:8000/api/customers/parameter/restore?trashed=1` <br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
    
    
<div id='orders'/>

## Módulo Pedido<br>

* **LISTAR PEDIDOS**<br>
    **method** : `GET`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br> 
    **url** : `http://localhost:8000/api/orders`<br>
    **paginate** : `http://localhost:8000/api/orders?page=2` <br>
    **per page** : `5`
    
* **CONSULTAR UM PEDIDO**<br>
    **method** : `GET`<br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br> 
    **parameter** : `código`<br>
    **url** : `http://localhost:8000/api/orders/parameter`<br>
    **excluidos** : `http://localhost:8000/api/orders/parameter?trashed=1`<br>

* **ADICIONAR UM PEDIDO**<br>
    **method** : `POST`<br>
    **body** : `form-data`<br>
    **headers**  `Accept: application/json`<br>
    **url** : `http://localhost:8000/api/orders`<br>
    **product** : `Código do Pastel` <br>
    **customer** : `Código do cliente` <br>
    **amount** : `Quantidade` <br>
    
* **ALTERAR PEDIDO**<br>
    **method** : `POST`<br>
    **body** : `form-data`<br>
    **headers**  `Accept: application/json`<br>
    **parameter** : `código ou id`<br>
    **url** : `http://localhost:8000/api/orders/codigo`<br>
    **product** : `Código do Pastel` <br>
    **customer** : `Código do cliente` <br>
    **amount** : `Quantidade` <br> 
    **_method** : `PUT` <br>
        
* **EXCLUIR PEDIDO**<br>
    **method** : `DELETE`<br>
    **body** : `form-data`<br>
    **headers**  `Accept: application/json`<br>
    **parameter** : `código ou id`<br>
    **url** : `http://localhost:8000/api/orders/codigo/`<br>
    
* **REATIVAR EXCLUIDO**<br>
    **method** : `PATCH`<br>
    **body** : `form-data`<br>
    **headers**  `Accept: application/json`<br>
    **parameter** : `código ou id`<br>
    **url** : `http://localhost:8000/api/orders/codigo/restore?trashed=1`<br>
    
    
<div id='reports'/>

## Relatórios<br>

* **PEDIDOS DE UM PASTEL ESPECÍFICO**<br>
    **method** : `GET`<br>
    **parameter** : `slug, código ou id.`<br>
    **url** : `http://localhost:8000/api/products/parameter/orders` <br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
    
* **PEDIDOS DE UM CLIENTE ESPECÍFICO**<br>
    **method** : `GET`<br>
    **parameter** : `slug, código ou id.`<br>
    **url** : `http://localhost:8000/api/customers/parameter/orders` <br>
    **body** : `raw -> JSON(application/json)`<br>
    **headers**  `Accept: application/json`<br>
        
<div id='mails'/>
  
## Disparo de E-mails      
* Foi criado Observers (created/updated), se a demanda fosse grande eu utilizaria as Queues do Laravel (Eventos/Filas)  e criaria um monitoramento.      
* Para receber o emails referente ao pedido, é preciso configurar a conta do mailtrap no .env  
```` 
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=*****
MAIL_PASSWORD=*****
MAIL_ENCRYPTION=****   
   
````    

## Instalação: Docker (NGINX)<br>
* em desenvolvimento

 
 
 
 