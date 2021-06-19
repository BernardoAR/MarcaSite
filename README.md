# MarcaSite

Seja bem-vindo(a) ao repositório de desenvolvimento do MarcaSite!

## Descrição

**MarcaSite** é um site web, com o foco em uma plataforma de curso, na qual pode ocorrer inscrições em um determinado curso.
O site foi pensado e desenvolvido para uma avaliação de conhecimentos

## Tecnologias

As tecnologias utilizadas para o desenvolvimento do site são as seguintes:

- Laravel como Framework PHP;
- Vue.js como Framework Front-end;
- MySQL como o banco de dados;
- Docker e Sail.

## Como utilizar
Para conseguir fazer a utilização do site localmente, siga os seguintes passos:
- Possuir o Docker, PHP e o  Composer instalado;
- Baixar o repositório em sua máquina;
- Entre na pasta do MarcaSite, e execute os comandos a seguir: 

Utilizando o composer, dentro da pasta MarcaSite, utilize o seguinte comando, no qual instalará o sail:

`composer require laravel/sail --dev`

Utilize os dois comandos a seguir, um para copiar o .env.example para o .env, e o outro para criar uma chave para o aplicativo

```
cp .env.example .env
php artisan key:generate
```
O comando a seguir irá baixar tudo o que for necessário no docker, além de subir o servidor, tanto mysql quanto para o PHP

`./vendor/bin/sail up` 

Após a finalização, serão necessárias as atualizações do pacote npm, sendo executada pelo comando a seguir: 

`./vendor/bin/sail npm install`

Existe o arquivo chamado .env.example, modifique o DB_DATABASE, USERNAME E PASSWORD a gosto, e renomeie o .env.example para .env
Exemplo de conexão utilizada:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=marcasite
DB_USERNAME=sail
DB_PASSWORD=password
```
Finalizado os comandos anteriores, é necessário utilizar o migrate para subir todas tabelas e colunas do banco de dados, sendo ela o comando a seguir:

`./vendor/bin/sail artisan migrate` 

Após isso, é só utilizar o aplicativo :)
