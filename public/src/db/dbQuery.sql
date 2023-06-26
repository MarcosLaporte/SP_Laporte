CREATE DATABASE IF NOT EXISTS sp_laporte;
USE sp_laporte;

/*-----------------------------------------------*/
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios(
    id INT PRIMARY KEY AUTO_INCREMENT,
    mail varchar(50) NOT NULL,
    clave varchar(250) NOT NULL,
    tipo INT NOT NULL,
    CONSTRAINT `tipo_check` CHECK (tipo = 0 OR tipo = 1)
) AUTO_INCREMENT = 101;

INSERT INTO usuarios(mail, clave, tipo) VALUES
    ('max@hotmail.com', '$2y$10$lSuWzPHKCKon4EoUV.MhVuGqffLYxhaM4Jaaxsnsw.2zE1a703iWW', 1),
    ('johnwick@babayaga.com', '$2y$10$UGUpk43Ux.5D2IN3hG3lM.Ha9LTbIigByGq4sPZ30xXj2tKb.7suG', 0),
    ('tomriddle@gmail.com', '$2y$10$Sg79/Qp/l.T2BqhWQpizhuFlzZL2WrM6Clpq8SwlLAxWBQQyLmwzm', 1);
/*-----------------------------------------------*/
DROP TABLE IF EXISTS criptomonedas;
CREATE TABLE criptomonedas(
	id INT PRIMARY KEY AUTO_INCREMENT,
	precio FLOAT NOT NULL,
	nombre varchar(250) NOT NULL,
	foto varchar(250) NOT NULL,
	nacionalidad varchar(250) NOT NULL
) AUTO_INCREMENT = 9001;

INSERT INTO criptomonedas(precio, nombre, foto, nacionalidad) VALUES
	(7692383.33, 'Bitcoin', 'public\src\FotosCripto\Bitcoin.jpg', 'USA'),
	(16.92, 'Dogecoin', 'public\src\FotosCripto\Dogecoin.jpg', 'Japon'),
	(125653.68, 'KeanuTok', 'public\src\FotosCripto\KeanuTok.jpg', 'Canada');
/*-----------------------------------------------*/
DROP TABLE IF EXISTS ventas;
CREATE TABLE ventas(
	id INT PRIMARY KEY AUTO_INCREMENT,
	fecha TEXT NOT NULL,
	cantidad FLOAT NOT NULL,
	idCripto INT NOT NULL,
	idCliente INT NOT NULL,
	foto varchar(250) NOT NULL,
	CONSTRAINT `idCriptoFK` FOREIGN KEY (idCripto) REFERENCES criptomonedas (id),
	CONSTRAINT `idClienteFK` FOREIGN KEY (idCliente) REFERENCES usuarios (id)
) AUTO_INCREMENT = 101;
/*-----------------------------------------------*/