# Back-end Challenge Doc88
Gerenciamento de pedidos de uma pastelaria

* Foi implementado os cabeçalhos de solicitação HTTP(CORS) par não ter problemas com o "header" nas requisições do Front-end.
````
-> app/Http/Middleware/CorsMiddleware.php
-> app/Http/Kernel.php
````
* Para não inflar as respostas em JSON e como não é aconselhado o retorno com os mesmos nomes dos campos do banco de dados , criei os Resources/Collection com os nomes dos campos que são realmente retornadas aos usuários do aplicativo.  
````
-> app/Http/Resources/Api
````
* Através da variável URL_PHOTOS localizada no arquivo .env , você poderá alterar o nome da url das fotos caso seja necessário.
 ````
 URL_PHOTOS=http://localhost:8000
 ````