CREATE TABLE IF NOT EXISTS sala (
  CodSala int NOT NULL primary key auto_increment,
  CodGrupo int NOT NULL,
  Nombre char(50) NOT NULL,
  Descripcion char(100) NOT NULL,
  Capacidad int DEFAULT '0' NOT NULL,
  CorreoAdministrador char(60) NOT NULL,
  Activo tinyint default 1,
  Orden smallInt DEFAULT '0',
  CodInstitucion integer not null
) engine=MyISAM;

CREATE TABLE IF NOT EXISTS grupo (
  CodGrupo int NOT NULL primary key auto_increment,
  Nombre char(50) NOT NULL,
  CorreoAdministrador char(60) NOT NULL,
  Activo tinyint default 1,
  CodInstitucion integer not null
) engine=MyISAM;

CREATE TABLE IF NOT EXISTS reserva (
	CodReserva INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    HoraInicio INT DEFAULT '0' NOT NULL,
	HoraFin INT DEFAULT '0' NOT NULL,
	CodRepeticion INT DEFAULT '0' NOT NULL,
	CodSala INT DEFAULT '0' NOT NULL,
	CodUsuario INT DEFAULT '0' NOT NULL,
	Nombre CHAR(80) DEFAULT '' NOT NULL,
	Descripcion CHAR(150),
	Notas CHAR(255),
	Estado TINYINT UNSIGNED NOT NULL DEFAULT 1,
	CodInstitucion INTEGER NOT NULL
) ENGINE=MYISAM;

CREATE TABLE IF NOT EXISTS repeticion (
	CodRepeticion INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	HoraInicio INT DEFAULT '0' NOT NULL,
	HoraFin INT DEFAULT '0' NOT NULL,
	DiaCompleto TINYINT DEFAULT '0' NOT NULL,
	FechaFinal INT DEFAULT '0' NOT NULL,
	DiasSemana  CHAR(7) DEFAULT '0000000' NOT NULL,
	CodSala INT DEFAULT '0' NOT NULL,
	CodUsuario INT DEFAULT '0' NOT NULL,
	Nombre CHAR(80) DEFAULT '' NOT NULL,
	Descripcion CHAR(150),
	PeriodoRepeticion CHAR(1) NOT NULL, 
	Estado TINYINT UNSIGNED NOT NULL DEFAULT 1,
	CodInstitucion INTEGER NOT NULL
) ENGINE=MYISAM;

create table valores (
  Clave CHAR(20) not null,
  Numero int default -1,
  Texto CHAR(100) default '',
  CodInstitucion integer not null,
  primary key (Clave, CodInstitucion)
);

create table IF NOT EXISTS institucion (
    CodInstitucion INTEGER not null primary key AUTO_INCREMENT, 
    Nombre char(50) not null,
	Contacto char(50) not null,
    Correo char(60) not null,
	CodPais INTEGER not null,
	SitioWeb char(60),
	Telefono char(20),
	Activo tinyint default 1,
	Notas char(255)
) engine=MyISAM; 

create table IF NOT EXISTS usuario (
    CodUsuario INTEGER not null primary key AUTO_INCREMENT, 
    Nombre char(50) not null,
	Correo char(60) not null,
	Nick char(12) not null,
	Clave char(32) not null,
	Activo tinyint default 1,
	TipoUsuario char(2) not null,
	CodInstitucion integer not null
) engine=MyISAM; 

insert into usuario (Nombre, Correo, Nick, Clave, TipoUsuario, CodInstitucion) values 
                    ('Luis Paez', 'luis@yahoo.com', 'luchop', md5('123456'), 0, 1);
insert into usuario (Nombre, Correo, Nick, Clave, TipoUsuario, CodInstitucion) values 
                    ('ASEA', 'asea@yahoo.com', 'admin', md5('mEJiJE37'), 1, 1);
insert into usuario (Nombre, Correo, Nick, Clave, TipoUsuario, CodInstitucion) values 
                    ('Juan Carlos Soto', 'juancarlos@yahoo.com', 'juancarlos', md5('112233'), 2, 1);
					
create table IF NOT EXISTS tipo_usuario (
    CodTipoUsuario INTEGER not null primary key AUTO_INCREMENT, 
	Nombre char(15) not null,
	CodInstitucion integer not null
) engine=MyISAM; 

insert into tipo_usuario values (1, 'Administrador', 0);
insert into tipo_usuario values (2, 'Usuario', 0);
