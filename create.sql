CREATE DATABASE motoristas_database;

CREATE TABLE IF NOT EXISTS veiculos (
    id SERIAL PRIMARY KEY, 
    placa VARCHAR(7) NOT NULL UNIQUE,
    renavam VARCHAR(30),
    modelo VARCHAR(20) NOT NULL,
    marca VARCHAR(20) NOT NULL,
    ano INT NOT NULL,
    cor VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE motoristas (
    id SERIAL PRIMARY KEY,
    nome varchar(200) not null,
    rg varchar(20) not null unique,
    cpf varchar(11) not null unique,
    telefone varchar(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- um motorista pode ter vários veículos
CREATE TABLE motoristas_veiculos (
    id SERIAL PRIMARY KEY,
    veiculo_id int not null,
    motorista_id int not null,
    foreign key (motorista_id) references motoristas(id),
    foreign key (veiculo_id) references veiculos(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
