# ![Logo](https://bitly.eduardocarlos.com.br/images/icon.png) Projeto Bitly - Encurtador de URL

**O projeto consiste em desenvolver uma aplicação para encurtar links, semelhante ao conhecido bit.ly, com uma interface inicial, onde o usuário irá inserir um link e como retorno terá uma URL curta.**

A referência e inspiração de UI foi do [DDSV Link Shortener](https://dribbble.com/shots/17087324-DDSV-Link-Shortener).

Demo URL: **[https://bitly.eduardocarlos.com.br](https://bitly.eduardocarlos.com.br)**

###### E-mail: test@example.com
###### Senha: password


### Tech Stack

- O Frontend foi feito com [tailwindcss](https://tailwindcss.com) e [Vue.js](https://vuejs.org/).
- O Backend foi feito com PHP usando o [Laravel Framework](https://laravel.com/)


## Pré-requisitos

1. PHP v8.1 ou superior:
    - Composer v2.3 ou superior.
2. Node v14 ou superior:
    - Yarn v1.22 ou superior;
    - NPM v6.14 ou superior.

## Configurnado a aplicação

1. Clone o repositório do [Bitly](https://github.com/educarlosdev/bitly) e navegue até a pasta de instalação

    ```bash
    git clone https://github.com/educarlosdev/bitly.git
    
    cd bitly
   ```

2. Copie o arquivo `.env.example` e cole, criando um arquivo chamado `.env`

    ```
    cp .env.example .env
    ```

3. Abra o arquivo `.env` e adicione as credenciais de banco de dados e a URL base do projeto (por padrão o Laravel utiliza a porta 8000 com endereço local. Ex.: http://127.0.0.1:8000).

   Exemplo de arquivo `.env` que configura o `APP_URL` e demais informações pertinentes ao banco de dados:

    ```
    APP_URL=http://127.0.0.1:8000
    [...]
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=bitly
    DB_USERNAME=root
    DB_PASSWORD=123456
    ```

### Rodando localmente

Siga as etapas abaixo para executar este aplicativo localmente

1. Rode o comando do `artisan key` para gerar a KEY do projeto

    ```bash
    php artisan key:generate
    ```

2. Rode o comando do `artisan migrate` para gerar as tabelas dentro do banco de dados

    ```bash
    php artisan migrate
    ```

3. Rode o comando do `artisan storage` para gerar o link simbólico para pasta storage

    ```bash
    php artisan storage:link
    ```

4. Como passo não obrigatório, caso queira popular a base de dados com informações fake utilizar o seguinte comando:

    ```bash
    php artisan db:seed
    ```

5. Instalar os pacotes com `yarn` ou `npm`:

    ```
    yarn install
    // ou
    npm run install
    ```

6.  Em ambiente sem Docker rode:

    ```bash
    php artisan serve
    
    yarn dev
    ```

7.  Em ambiente com Docker rode:

    ```bash
    docker-compose up --build -d
    
    docker exec -it [container_name] yarn dev
    ```

8.  Aos optantes do [Laravel Sail](https://laravel.com/docs/10.x/sail):

    ```bash
    ./vendor/bin/sail up -d
    
    ./vendor/bin/sail yarn dev
    ```

9.  Abra seu navegador e visite localhost: [http://127.0.0.1:8000](http://127.0.0.1:8000).

