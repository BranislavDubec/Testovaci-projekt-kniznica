USE library;
DROP TABLE IF EXISTS  Kniha;
DROP TABLE IF EXISTS Author;
DROP TABLE IF EXISTS Kategoria;
CREATE TABLE Autor (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    meno VARCHAR(50) NOT NULL UNIQUE
);
Create TABLE kategoria(
    nazov VARCHAR(50) PRIMARY KEY NOT NULL
);
CREATE TABLE Kniha (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nazov VARCHAR(50) NOT NULL,
	ISBN VARCHAR(50) NOT NULL,
	cena FLOAT NOT NULL,
	autor INT(6) UNSIGNED NOT NULL,
	kategoria VARCHAR(50) NOT NULL,
	FOREIGN KEY(autor) REFERENCES autor(id),
	foreign key (kategoria) references kategoria(nazov)
);

INSERT INTO kategoria(nazov)
values("horor");
INSERT INTO kategoria(nazov)
values("triller");
INSERT INTO kategoria(nazov)
values("román");
INSERT INTO kategoria(nazov)
values("fantasy");
