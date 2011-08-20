CREATE TABLE IF NOT EXISTS sala (
  CodSala int NOT NULL primary key auto_increment,
  CodGrupo int NOT NULL,
  Nombre char(50) NOT NULL,
  Descripcion char(100) NOT NULL,
  Capacidad int DEFAULT '0' NOT NULL,
  CorreoAdministrador char(60) NOT NULL,
  Activo smallInt default 1,
  Orden INT DEFAULT '0' NOT NULL,
  CodInstitucion integer not null
) engine=MyISAM;

CREATE TABLE IF NOT EXISTS grupo (
  CodGrupo int NOT NULL primary key auto_increment,
  Nombre char(50) NOT NULL,
  CorreoAdministrador char(60) NOT NULL,
  Activo smallInt default 1,
  CodInstitucion integer not null
) engine=MyISAM;

CREATE TABLE IF NOT EXISTS reserva (
	CodReserva int NOT NULL primary key auto_increment,
    HoraInicio int DEFAULT '0' NOT NULL,
	HoraFin int DEFAULT '0' NOT NULL,
	CodRepeticion int DEFAULT '0' NOT NULL,
	CodSala int DEFAULT '1' NOT NULL,
	CodUsuario int DEFAULT '1' NOT NULL,
	Nombre varchar(80) DEFAULT '' NOT NULL,
	Descripcion text,
	Estado tinyint unsigned NOT NULL DEFAULT 1,
	CodInstitucion integer not null
) engine=MyISAM;

CREATE TABLE IF NOT EXISTS repeticion (
	CodRepeticion int NOT NULL primary key auto_increment,
	HoraInicio int DEFAULT '0' NOT NULL,
	HoraFin int DEFAULT '0' NOT NULL,
	DiaCompleto int DEFAULT '0' NOT NULL,
	FechaFinal int DEFAULT '0' NOT NULL,
	DiasSemana  char(7) DEFAULT '' NOT NULL,
	CodSala int DEFAULT '1' NOT NULL,
	CodUsuario int DEFAULT '1' NOT NULL,
	Nombre varchar(80) DEFAULT '' NOT NULL,
	Descripcion text,
	PeriodoRepeticion char(1), 
	Estado tinyint unsigned NOT NULL DEFAULT 1,
	CodInstitucion integer not null
) engine=MyISAM;


create table valores (
  Clave CHAR(20) not null primary key,
  Numero int default -1,
  Texto CHAR(100) default '',
  CodInstitucion integer not null
);

create table IF NOT EXISTS institucion (
    CodInstitucion INTEGER not null primary key AUTO_INCREMENT, 
    Nombre char(50) not null,
	Contacto char(50) not null,
    Correo char(60) not null,
	CodPais INTEGER not null,
	SitioWeb char(60),
	Telefono char(20),
	Activo smallInt default 1,
	Notas char(255)
) engine=MyISAM; 

create table IF NOT EXISTS usuario (
    CodUsuario INTEGER not null primary key AUTO_INCREMENT, 
    Nombre char(50) not null,
	Correo char(60) not null,
	Nick char(12) not null,
	Clave char(32) not null,
	Activo smallInt default 1,
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
insert into tipo_usuario values (2, 'Operador 1', 0);
insert into tipo_usuario values (3, 'Operador 2', 0);