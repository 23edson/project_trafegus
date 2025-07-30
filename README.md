## Desafio - Trafegus

### Stack Utilizada: 

    *Laminas Framework
    *PHP 8.2
    *ORM Doctrine2
    *Banco de dados PostgreSQL15
    *jQuery + Tabulator.js
    *Composer

### Como executar

#### 1. Executar composer install (na pasta src);

#### 2. Criar base de dados no postgres (script disponível no arquivo 'create.sql' na raiz do projeto);
    Credenciais utilizadas no projeto:
        'host' => 'localhost',
        'port'     => '5432',
        'user'     => 'postgres',
        'password' => 'postgres',
        'dbname'   => 'motoristas_database',
        'charset'  => 'utf8',

### 3. Executar os testes
    ./vendor/bin/phpunit



