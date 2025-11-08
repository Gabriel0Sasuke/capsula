CREATE DATABASE capsula;
USE capsula;

CREATE TABLE post (
    id INT AUTO_INCREMENT PRIMARY KEY,
    conteudo TEXT NOT NULL,
    data_publicacao DATETIME NOT NULL,
    imagem VARCHAR(255) NOT NULL
);
