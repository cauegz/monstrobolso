
CREATE TABLE categoria
(
  id   INT     NOT NULL GENERATED ALWAYS AS IDENTITY,
  tipo CHAR(1) NOT NULL UNIQUE CHECK (tipo IN ('1','2','3')),
  PRIMARY KEY (id)
);

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

CREATE TABLE itens_compra
(
  id         INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  quantidade INT NOT NULL,
  id_produto INT NOT NULL,
  id_usuario INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE loja
(
  id           INT     NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome         CHAR(2) NOT NULL UNIQUE CHECK (nome IN ('l1','l2','l3')),
  categoria_id INT     NOT NULL,
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

CREATE TABLE produto
(
  id           INT           NOT NULL GENERATED ALWAYS AS IDENTITY,
  nome         VARCHAR(100)  NOT NULL,
  preco        DECIMAL(10,2) NOT NULL,
  estoque      INT           NOT NULL,
  categoria_id INT           NOT NULL,
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

CREATE TABLE venda
(
  id              INT NOT NULL GENERATED ALWAYS AS IDENTITY,
  id_itens_compra INT NOT NULL,
  id_loja         INT NOT NULL,
  PRIMARY KEY (id)
);

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

ALTER TABLE produto
  ADD CONSTRAINT FK_categoria_TO_produto
    FOREIGN KEY (categoria_id)
    REFERENCES categoria (id);

ALTER TABLE loja
  ADD CONSTRAINT FK_categoria_TO_loja
    FOREIGN KEY (categoria_id)
    REFERENCES categoria (id);

ALTER TABLE venda
  ADD CONSTRAINT FK_loja_TO_venda
    FOREIGN KEY (id_loja)
    REFERENCES loja (id);

ALTER TABLE venda
  ADD CONSTRAINT FK_itens_compra_TO_venda
    FOREIGN KEY (id_itens_compra)
    REFERENCES itens_compra (id);

ALTER TABLE itens_compra
  ADD CONSTRAINT FK_produto_TO_itens_compra
    FOREIGN KEY (id_produto)
    REFERENCES produto (id);

ALTER TABLE itens_compra
  ADD CONSTRAINT FK_usuario_TO_itens_compra
    FOREIGN KEY (id_usuario)
    REFERENCES usuario (id);