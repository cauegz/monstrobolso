<?php

class Time implements JsonSerializable
{
    private static $pdo;

    private ?int $id = null;
    private int $treinador;
    private int $posicao = 1;
    private int $pokemon;

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
        $sql = 'SELECT id, id_treinador as "treinador", id_pokemon as "pokemon", posicao
                FROM time
                WHERE id = :id';

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();

        return $result->fetchObject(self::class);
    }

    public static function all($filter = null)
    {
        $sql = 'SELECT id, id_treinador as "treinador", id_pokemon as "pokemon", posicao
                FROM time';

        if ($filter) {
            $sql .= " WHERE " . $filter;
        }

        $result = self::getPDO()->prepare($sql);

        $result->execute();

        return $result->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function delete(int $id)
    {
        $sql = "DELETE FROM time
                WHERE id = :id";

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();
    }

    public function save()
    {
        if ($this->id == null) {

            $sql = "INSERT INTO time (id_pokemon, id_treinador, posicao)
                    VALUES (:pokemon, :treinador, :posicao)";

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":pokemon", $this->pokemon);
            $result->bindParam(":treinador", $this->treinador);
            $result->bindParam(":posicao", $this->posicao);

            $result->execute();

            $this->id = self::getPDO()->lastInsertId();

        } else {

            $sql = "UPDATE time
                    SET id_pokemon = :pokemon,
                        id_treinador = :treinador,
                        posicao = :posicao
                    WHERE id = :id";

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":pokemon", $this->pokemon);
            $result->bindParam(":treinador", $this->treinador);
            $result->bindParam(":posicao", $this->posicao);
            $result->bindParam(":id", $this->id);

            $result->execute();
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->id,
            "posicao" => $this->posicao,
            "pokemon" => $this->pokemon,
            "treinador" => $this->treinador
        ];
    }
}