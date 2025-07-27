

insert into motoristas (nome, rg, cpf, telefone) values
('João da Silva', '123456789', '12345678901', '11987654321'),
('Maria Oliveira', '987654321', '10987654321', '11912345678'),
('Carlos Souza', '456789123', '23456789012', '11876543210');

INSERT INTO veiculos (placa, renavam, modelo, marca, ano, cor) VALUES
('KLM2345', '98765432101234567', 'Actros', 'Mercedes-Benz', 2022, 'branco'),
('TRK7890', '87654321012345678', 'FH 540', 'Volvo', 2021, 'prata'),
('CNH4567', '76543210123456789', 'Constellation', 'Volkswagen', 2020, 'vermelho');

INSERT INTO motoristas_veiculos (veiculo_id, motorista_id) VALUES
(1, 1), -- João da Silva owns Actros
(2, 2), -- Maria Oliveira owns FH 540
(3, 3); -- Carlos Souza owns Constellation

