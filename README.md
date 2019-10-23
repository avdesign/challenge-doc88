# Back-end Challenge Doc88

Gerenciamento de pedidos de uma pastelaria

*******
1. [Inplementos](#implemen)
2. [Instalação](#install)

*******
<div id='implemen'/>

## Inplementos<br>
* Foi implementado os cabeçalhos de solicitação HTTP(CORS) para não ter problemas com o "header" nas requisições do Front-end.
````
-> app/Http/Middleware/CorsMiddleware.php
-> app/Http/Kernel.php
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
DB_DATABASE=**********  
DB_USERNAME=**********  
DB_PASSWORD=**********

* Para criar as tabelas e gerar as fotos dos pasteis digite os camandos: 
````
$ php artisan migrate --seed
$ php artisan serve
````


## Instalação Docker com NGINX<br>
* em desenvolvimento
 
 
 