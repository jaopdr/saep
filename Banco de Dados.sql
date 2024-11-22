CREATE DATABASE saep_db;
USE saep_db;

CREATE TABLE professores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(100) NOT NULL
);

CREATE TABLE turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    professor_id INT NOT NULL,
    FOREIGN KEY (professor_id) REFERENCES professores(id)
);

CREATE TABLE atividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    turma_id INT NOT NULL,
    FOREIGN KEY (turma_id) REFERENCES turmas(id)
);

INSERT INTO professores (nome, email, senha)
VALUES ("joao", "joao@gmail.com", "joao123"),
	   ("henrique", "henrique@gmail.com", "henrique123"),
	   ("luis", "luis@gmail.com", "luis123");
       
select * from professores;