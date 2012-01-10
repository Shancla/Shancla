create database shancla_db ;

use shancla_db;

create table anuncios (
	id_anuncios int not null auto_increment primary key,
	titulo varchar(250) not null,
	descripcion text not null,
	precio double(10,2),
	fecha_publicacion timestamp,
	publicado boolean default false,
	borrado boolean default false,
	caducado boolean default false,
	lat float(10,6) not null,
	lng float(10,6) not null,
	video varchar(255),
	direccion varchar(255) not null, 
	visitas int,
	clave varchar(40) not null,
	FULLTEXT (titulo, descripcion)
	);

create table usuarios(
	id_usuario int not null auto_increment primary key,
	email varchar(255) not null,
	telefono varchar(15),
	registrado boolean default false
	);

create table imagenes(
	id_imagen int not null auto_increment primary key,
	nombre_imagen varchar(50) not null 
);

create table marcadores(
	id_marcador int not null auto_increment primary key,
	nombre_marcador varchar(50) not null
);

create table etiquetas(
	id_etiqueta int not null auto_increment primary key,
	etiqueta varchar(50) not null,
	FULLTEXT (etiqueta);
);

create table categorias(
	id_categoria int not null auto_increment primary key,
	categoria varchar(50) not null
);


create table caducidad(
	id_caducidad int not null auto_increment primary key,
	caducidad varchar(50) not null,
	dias int 
);
	
create table interesados(
	id_interesado int not null auto_increment primary key,
	email varchar(255) not null,
	ip varchar(15) not null,
	fecha_contacto timestamp
	);	

CREATE TABLE etiquetas_y_anuncios (
 	id_eya int not null auto_increment primary key,
	id_etiqueta int not null,
	id_anuncios int not null
);	