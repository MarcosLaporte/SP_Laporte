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
