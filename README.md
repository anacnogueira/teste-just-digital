# Just Digital

## Desafio de contratação - Desenvolvedor Back-end

### Intruções

1. Instale as dependencias: composer install
2. Renomeie o arquivo `env.sample` para `.env` e configure as variaveis de conexão com o banco de dados
3. Execute o arquivo `create_posts_table.sql` para criar a tabela

### Endpoints 

| Method 	| Endpoints         				| Explanation  			|
| ----------|:---------------------------------:| --------------------:	|
| GET    	| posts/read.php 					| Lista todos os posts 	|
| GET    	| posts/readById.php?id=id			| Mostra Post por ID 	|
| GET 		| posts/readByPath.php?path={path}  | Mostra Post por Path	|
| POST 		| posts/create.php  				| Cadastra novo Post	|
| POST 		| posts/update.php?id={id}  		| Altera Post			|
| POST 		| posts/delete.php?id={id}  		| Exclui Post			|
