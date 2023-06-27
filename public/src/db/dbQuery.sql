CREATE DATABASE IF NOT EXISTS sp_laporte;
USE sp_laporte;

/*-----------------------------------------------*/
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios(
    id INT PRIMARY KEY AUTO_INCREMENT,
    mail VARCHAR(50) NOT NULL,
    clave VARCHAR(250) NOT NULL,
    tipo INT NOT NULL,
    CONSTRAINT `tipo_check` CHECK (tipo = 0 OR tipo = 1)
) AUTO_INCREMENT = 101;

INSERT INTO usuarios(mail, clave, tipo) VALUES
    ('max@hotmail.com', '$2y$10$EN34u.Azhx3y9aF41LY//e3K7.Fx0atMsqAlxkB/c4u06A.jQ4CeS', 1),
    ('marcos@gmail.com', '$2y$10$EN34u.Azhx3y9aF41LY//e3K7.Fx0atMsqAlxkB/c4u06A.jQ4CeS', 0),
    ('tomriddle@gmail.com', '$2y$10$EN34u.Azhx3y9aF41LY//e3K7.Fx0atMsqAlxkB/c4u06A.jQ4CeS', 1);
/*-----------------------------------------------*/
DROP TABLE IF EXISTS criptomonedas;
CREATE TABLE criptomonedas(
	id INT PRIMARY KEY AUTO_INCREMENT,
	precio FLOAT NOT NULL,
	nombre VARCHAR(250) NOT NULL,
	foto VARCHAR(250) NOT NULL,
	nacionalidad VARCHAR(250) NOT NULL
) AUTO_INCREMENT = 9001;

INSERT INTO criptomonedas(precio, nombre, foto, nacionalidad) VALUES
	(7692383.33, 'Bitcoin', 'src/FotosCripto/Bitcoin.jpg', 'USA'),
	(16.92, 'Dogecoin', 'src/FotosCripto/Dogecoin.jpg', 'Japon'),
	(125653.68, 'KeanuTok', 'src/FotosCripto/KeanuTok.jpg', 'Canada');
/*-----------------------------------------------*/
DROP TABLE IF EXISTS ventas;
CREATE TABLE ventas(
	id INT PRIMARY KEY AUTO_INCREMENT,
	fecha VARCHAR(12) NOT NULL,
	cantidad FLOAT NOT NULL,
	idCripto INT,
	idCliente INT NOT NULL,
	foto VARCHAR(250) NOT NULL,
	-- CONSTRAINT `idCriptoFK` FOREIGN KEY (idCripto) REFERENCES criptomonedas (id) ON DELETE SET NULL,
	-- CONSTRAINT `idClienteFK` FOREIGN KEY (idCliente) REFERENCES usuarios (id)
) AUTO_INCREMENT = 101;
/*-----------------------------------------------*/
DROP TABLE IF EXISTS logs;
CREATE TABLE logs(
	idUsuario INT NOT NULL,
	idCripto INT NOT NULL,
	accion VARCHAR(250) NOT NULL,
	fecha_accion VARCHAR(12) NOT NULL,
	-- CONSTRAINT `idUsuarioFK` FOREIGN KEY (idUsuario) REFERENCES usuarios (id),
	-- CONSTRAINT `idCriptoLogFK` FOREIGN KEY (idCripto) REFERENCES criptomonedas (id)
);
/*-----------------------------------------------*/