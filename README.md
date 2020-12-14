
![alt text](https://i.imgur.com/Z3usKgn.gif "demo")

# sobre o projeto
**Montar uma interface que seja possível criar uma lista de séries que você já viu e que quer ver.**
Séries:
- Já vi
- Quero ver
- Adicionar nova série
- Remover série
- Editar e/ou atualizar série

### Os dados básicos que a série precisa ter:
- nome da série
- Ano de lançamento
- número de temporadas
- sinopse
- categoria (terror, comédia, drama etc)

## Como fazer deploy localmente
### Requisitos 
É necessário ter instado 
- PHP 7.3^ e algumas extensões
    - BCMath PHP Extension
    - Ctype PHP Extension
    - Fileinfo PHP Extension
    - JSON PHP Extension
    - Mbstring PHP Extension
    - OpenSSL PHP Extension
    - PDO PHP Extension
    - Tokenizer PHP Extension
    - XML PHP Extension
- Composer
    - O Laravel utiliza o Composer para gerenciar suas dependências. Portanto, antes de usar o Laravel, certifique-se de ter o Composer instalado em sua máquina.
- Mysql 
- Node & Npm

### Baixar e instalar dependências do projeto
**composer install** - O composer vai lidar com as dependências do Laravel

**Editar arquivo .env.example** - Após rodar o comando acima na raiz da projeto podemos encontrar o seguinte arquivo ".env.example". Precisamos gerar um cópia do mesmo com o seguinte nome ".env" para fazer numa distro linux podemos usar o comando:
~~~bash
cp .env.example .env
~~~
Feito isso basta alterar os parametros necessarios para acessar a base de dados. Por exemplo.
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nomeDaBaseDeDados
DB_USERNAME=Usuario
DB_PASSWORD=Senha
**OBS: A base de dados precisar ser criada previamente.**

**php artisan key:generate** - Para criar uma chave em APP_KEY= no arquivo .env

**npm install** - O Npm vai lidar com as dependencias do Vuejs.

**php artisan migrate** - Para criar as tabelas na base de dados.

**php artisan db:seed** - Para alimentar as tabelas criadas anteriormente.

**php artisan storage:link** - O diretório storage/app/public pode ser usado para armazenar arquivos gerados pelo usuário, como avatares de perfil, que devem ser acessíveis ao público. Você deve criar um link simbólico em public/storage que aponta para este diretório.

**Diversas formas de fazer o mesmo**
 Se você instalou o PHP localmente e gostaria de usar o servidor de desenvolvimento embutido do PHP para servir sua aplicação, você pode usar o comando Artisan serve. Este comando iniciará um servidor de desenvolvimento em http: // localhost: 8000:
~~~bash
php artisan serve
~~~

OBS: não é a opção mais robusta. existem outros métodos por exemplo:
- Laragon (A melhor solução para windown)  https://www.youtube.com/watch?v=KBimnW4WeBg
- Xampp com VirtualHost https://youtu.be/X4aaPtEbeVM
- Laradock com Docker https://www.youtube.com/watch?v=6XfZLqoywz4
- Nginx 
- Homestead e Valet

Mais detalhes sobre na Documentação do  [Laravel](https://laravel.com/docs/8.x#server-requirements) 


## Permissões em diretórios
Basicamente precisamos dar permissão pra alguns diretorios.
- storage 
- vendor 

As permissões para as pastas storage e vendor devem permanecer em 775, por razões de segurança óbvias.
Mas em um ambiente como este podemos simplesmente usar o comando
~~~bash
sudo chmod 777 -R /pasta_do_projeto/storage/
~~~

---

### Detalhes
Na requisição:
~~~php
getTvShows()
~~~

Tem uma função:
~~~php
sleep(1)
~~~
Para "Simular" o carregamento em produção e poder ler o Loading.
