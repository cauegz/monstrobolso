
CREATE TABLE efeito
(
  id_efeito INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome      VARCHAR(100) NOT NULL UNIQUE,
  PRIMARY KEY (id_efeito)
);

CREATE TABLE inventario
(
  id_inventario INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_item       INT NOT NULL,
  id_treinador  INT NOT NULL,
  PRIMARY KEY (id_inventario)
);

CREATE TABLE npc
(
  id_npc      INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome        VARCHAR(100) NOT NULL,
  id_tipo_npc INT          NOT NULL,
  PRIMARY KEY (id_npc)
);

CREATE TABLE pokemon
(
  id_pokemon   INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_efeito    INT NOT NULL,
  hp           INT NOT NULL,
  id_treinador INT NOT NULL,
  PRIMARY KEY (id_pokemon)
);

CREATE TABLE tipo_npc
(
  id_tipo_npc INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome        VARCHAR(100) NOT NULL,
  PRIMARY KEY (id_tipo_npc)
);

CREATE TABLE treinador
(
  id_treinador INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_npc       INT NOT NULL,
  id_usuario   INT NOT NULL,
  PRIMARY KEY (id_treinador)
);

CREATE TABLE usuario
(
  id_usuario INT          NOT NULL GENERATED ALWAYS AS IDENTITY,
  login      VARCHAR(100) NOT NULL UNIQUE,
  senha      VARCHAR(255) NOT NULL,
  nome       VARCHAR(100),
  PRIMARY KEY (id_usuario)
);

ALTER TABLE npc
  ADD CONSTRAINT FK_tipo_npc_TO_npc
    FOREIGN KEY (id_tipo_npc)
    REFERENCES tipo_npc (id_tipo_npc);

ALTER TABLE pokemon
  ADD CONSTRAINT FK_efeito_TO_pokemon
    FOREIGN KEY (id_efeito)
    REFERENCES efeito (id_efeito);

ALTER TABLE treinador
  ADD CONSTRAINT FK_npc_TO_treinador
    FOREIGN KEY (id_npc)
    REFERENCES npc (id_npc);

ALTER TABLE treinador
  ADD CONSTRAINT FK_usuario_TO_treinador
    FOREIGN KEY (id_usuario)
    REFERENCES usuario (id_usuario);

ALTER TABLE pokemon
  ADD CONSTRAINT FK_treinador_TO_pokemon
    FOREIGN KEY (id_treinador)
    REFERENCES treinador (id_treinador);

ALTER TABLE inventario
  ADD CONSTRAINT FK_treinador_TO_inventario
    FOREIGN KEY (id_treinador)
    REFERENCES treinador (id_treinador);
