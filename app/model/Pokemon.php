<?php

class Pokemon implements JsonSerializable
{
    private static $pdo;

    private ?int $id = null;
    private int $pokeApi;

    //status
    private int $hp;
    private int $ataque;
    private int $ataqueEspecial;
    private int $defesa;
    private int $defesaEspecial;
    private int $velocidade;

    //chaves estrangeiras
    private ?int $efeito;
    private int $treinador;

    private static function getPDO()
    {
        if (self::$pdo === null) {
            self::$pdo = Conexao::getPDO();
        }

        return self::$pdo;
    }

    public function __get(string $nome)
    {
        return $this->$nome;
    }

    public function __set(string $nome, $valor)
    {
        $this->$nome = $valor;
    }

    public static function find($id)
    {
        $sql = 'SELECT id, hp, ataque, defesa, velocidade,
                    id_pokeapi AS "pokeApi",
                    id_efeito AS "efeito",
                    id_treinador AS "treinador",
                    ataque_especial AS "ataqueEspecial",
                    defesa_especial AS "defesaEspecial"
                FROM pokemon
                WHERE id = :id;';

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();

        return $result->fetchObject(self::class);
    }

    public static function all($filter = null)
    {
        $sql = 'SELECT id, hp, ataque, defesa, velocidade, 
                    id_pokeapi as "pokeApi", 
                    id_efeito as "efeito",
                    id_treinador as "treinador",
                    ataque_especial as "ataqueEspecial",
                    defesa_especial as "defesaEspecial"
                FROM pokemon';

        if ($filter) {
            $sql .= " WHERE " . $filter;
        }

        $result = self::getPDO()->prepare($sql);

        $result->execute();

        return $result->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function delete(int $id)
    {
        $sql = "DELETE FROM pokemon
                WHERE id = :id";

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();
    }

    public function save()
    {
        if ($this->id == null) {

            $sql = "INSERT INTO pokemon (
                        id_pokeapi, hp, ataque, 
                        defesa, ataque_especial, 
                        defesa_especial, velocidade, 
                        id_efeito, id_treinador
                    )
                    VALUES (
                        :pokeApi, :hp, :ataque, 
                        :defesa, :ataqueEspecial, 
                        :defesaEspecial, :velocidade, 
                        :efeito, :treinador
            )";

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":pokeApi", $this->pokeApi);
            $result->bindParam(":hp", $this->hp);
            $result->bindParam(":ataque", $this->ataque);
            $result->bindParam(":defesa", $this->defesa);
            $result->bindParam(":ataqueEspecial", $this->ataqueEspecial);
            $result->bindParam(":defesaEspecial", $this->defesaEspecial);
            $result->bindParam(":velocidade", $this->velocidade);
            $result->bindParam(":efeito", $this->efeito);
            $result->bindParam(":treinador", $this->treinador);

            $result->execute();

            $this->id = self::getPDO()->lastInsertId();

        } else {

            $sql = "UPDATE pokemon
                    SET id_pokeapi = :pokeApi, 
                        hp = :hp, 
                        ataque = :ataque, 
                        defesa = :defesa, 
                        ataque_especial = :ataqueEspecial, 
                        defesa_especial = :defesaEspecial, 
                        velocidade = :velocidade, 
                        id_efeito = :efeito, 
                        id_treinador = :treinador
                    WHERE id = :id";

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":pokeApi", $this->pokeApi);
            $result->bindParam(":hp", $this->hp);
            $result->bindParam(":ataque", $this->ataque);
            $result->bindParam(":defesa", $this->defesa);
            $result->bindParam(":ataqueEspecial", $this->ataqueEspecial);
            $result->bindParam(":defesaEspecial", $this->defesaEspecial);
            $result->bindParam(":velocidade", $this->velocidade);
            $result->bindParam(":efeito", $this->efeito);
            $result->bindParam(":treinador", $this->treinador);
            $result->bindParam(":id", $this->id);

            $result->execute();
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->id,
            "pokeApi" => $this->pokeApi,
            "hp" => $this->hp,
            "ataque" => $this->ataque,
            "defesa" => $this->defesa,
            "ataqueEspecial" => $this->ataqueEspecial,
            "defesaEspecial" => $this->defesaEspecial,
            "velocidade" => $this->velocidade,
            "efeito" => $this->efeito,
            "treinador" => $this->treinador
        ];
    }
}