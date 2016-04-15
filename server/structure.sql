create database videogames;

use videogames; 

GRANT ALL PRIVILEGES ON videogames.* TO 'admin'@'localhost';

FLUSH PRIVILEGES;

CREATE TABLE  games(
  id int not null auto_increment PRIMARY KEY,
    titulo varchar(60) not null,
    desarrollador varchar(100) not null,
    descripcion varchar(255) not null,
    consola varchar(60) not null,
    fehaLanzamiento date not null,
    calificacion float NOT NULL,
    imagenURL varchar(255) not null
  );
  
  
insert into games
(titulo, desarrollador, descripcion, consola, fehaLanzamiento, calificacion, imagenURL)
values
('Super Mario 3', 'Mario','El Mundo Champiñón es atacado por el Rey de los Koopas', 'Nintendo Entertainment System', '1988-10-23', 4, 'https://es.wikipedia.org/wiki/Super_Mario_Bros._3#/media/File:Supermariobros3logo.svg');

select * from games;