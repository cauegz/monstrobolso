
CREATE TABLE efeito
(
  id   INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome VARCHAR(100) NOT NULL UNIQUE,
  PRIMARY KEY (id)
);

CREATE TABLE inventario
(
  id           INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_item      INT NOT NULL,
  id_treinador INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE npc
(
  id          INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome        VARCHAR(100) NOT NULL,
  id_tipo_npc INT          NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE pokemon
(
  id           INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_efeito    INT NOT NULL,
  hp           INT NOT NULL,
  id_treinador INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE tipo_npc
(
  id   INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE treinador
(
  id         INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_npc     INT NOT NULL,
  id_usuario INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE usuario
(
  id    INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  login VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  nome  VARCHAR(100),
  PRIMARY KEY (id)
);


create table categoria
(
  id   INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  tipo char(1) check (tipo in ('1', '2', '3')) NOT NULL UNIQUE,
  PRIMARY KEY (id)
);
create table loja
(
  id   INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome CHAR(2) CHECK (nome IN ('l1', 'l2', 'l3')) NOT NULL UNIQUE,
  --categoria_id int not null 
  categoria_id integer REFERENCES categoria (id),
  PRIMARY KEY (id)
);
create table produto
(
	id INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
	nome varchar(100) not null,
	preco decimal(10,2) not null check(preco < '0'),
	estoque int not null check(estoque < '-1'),
	categoria_id integer REFERENCES categoria (id),
	PRIMARY KEY (id)
	
);
create table itens_compra(
	id INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
	quantidade int not null check(quantidade < 0),
	id_produto integer REFERENCES produto (id) not null,
	id_usuario integer REFERENCES usuario (id) not null,
	PRIMARY KEY (id)
);
create table venda(
	id INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
	id_itens_compra integer REFERENCES itens_compra (id) not null,
	id_loja integer REFERENCES loja (id) not null,
	PRIMARY KEY (id)
);

alter table loja
alter column categoria_id set not null;

alter table produto
alter column categoria_id set not null;


ALTER TABLE npc
  ADD CONSTRAINT FK_tipo_npc_TO_npc
    FOREIGN KEY (id_tipo_npc)
    REFERENCES tipo_npc (id);

ALTER TABLE pokemon
  ADD CONSTRAINT FK_efeito_TO_pokemon
    FOREIGN KEY (id_efeito)
    REFERENCES efeito (id);

ALTER TABLE treinador
  ADD CONSTRAINT FK_npc_TO_treinador
    FOREIGN KEY (id_npc)
    REFERENCES npc (id);

ALTER TABLE treinador
  ADD CONSTRAINT FK_usuario_TO_treinador
    FOREIGN KEY (id_usuario)
    REFERENCES usuario (id);

ALTER TABLE pokemon
  ADD CONSTRAINT FK_treinador_TO_pokemon
    FOREIGN KEY (id_treinador)
    REFERENCES treinador (id);

ALTER TABLE inventario
  ADD CONSTRAINT FK_treinador_TO_inventario
    FOREIGN KEY (id_treinador)
    REFERENCES treinador (id);