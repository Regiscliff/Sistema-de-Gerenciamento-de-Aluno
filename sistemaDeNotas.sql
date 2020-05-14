DROP DATABASE IF EXISTS sistemaDeNotas;
CREATE DATABASE sistemaDeNotas;
USE sistemaDeNotas;

CREATE TABLE disciplina(
cd_disciplina INT NOT NULL AUTO_INCREMENT,
nm_disciplina VARCHAR(30) NOT NULL,
PRIMARY KEY(cd_disciplina),
UNIQUE KEY(nm_disciplina));

ALTER TABLE disciplina AUTO_INCREMENT=1111;

CREATE TABLE aluno(
cd_aluno INT NOT NULL AUTO_INCREMENT,
nm_aluno VARCHAR(50) NOT NULL,
email VARCHAR(60) NOT NULL,
PRIMARY KEY(cd_aluno),
UNIQUE KEY(nm_aluno));

ALTER TABLE aluno AUTO_INCREMENT=222222;

CREATE TABLE aluno_disciplina(
cd_aluno INT NOT NULL,
cd_disciplina INT NOT NULL,
a1 DOUBLE,
a2 DOUBLE,
a3 DOUBLE,
PRIMARY KEY(cd_aluno, cd_disciplina),
FOREIGN KEY(cd_aluno) REFERENCES aluno(cd_aluno),
FOREIGN KEY(cd_disciplina) REFERENCES disciplina(cd_disciplina));

CREATE TABLE telefone_aluno(
cd_telefone INT NOT NULL AUTO_INCREMENT,
ddd INT NOT NULL,
num_telefone INT NOT NULL,
cd_aluno INT NOT NULL,
PRIMARY KEY(cd_telefone),
FOREIGN KEY(cd_aluno) REFERENCES aluno(cd_aluno));

CREATE TABLE endereco_aluno(
cd_endereco INT NOT NULL AUTO_INCREMENT,
cep INT,
rua VARCHAR(50) NOT NULL,
numero INT NOT NULL,
bairro VARCHAR(30) NOT NULL,
cidade VARCHAR(30) NOT NULL,
estado CHAR(2) NOT NULL,
cd_aluno INT NOT NULL,
PRIMARY KEY(cd_endereco),
FOREIGN KEY(cd_aluno) REFERENCES aluno(cd_aluno));