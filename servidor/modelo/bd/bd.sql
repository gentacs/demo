create database demo_abf;
CREATE TABLE demo_abf.cliente(
	id INT NOT NULL AUTO_INCREMENT,
	nombre VARCHAR (25) NOT NULL,
	apellido_paterno VARCHAR (25) NOT NULL,
	apellido_materno VARCHAR (25),
	fono VARCHAR(15),
	PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE demo_abf.trabajo(
	id INT NOT NULL AUTO_INCREMENT,
	fecha date NOT NULL,
	descripcion VARCHAR(255) NOT NULL,
	cliente_id INT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(cliente_id) REFERENCES cliente(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;