<?php

class Time extends ModelGeral implements JsonSerializable, ModelInterface
{
    protected int $treinador;
    protected int $posicao = 1;
    protected int $pokemon;

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

    public static function delete($id)
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
   
    public static function findByTreinadorAndPosicao($treinador, $posicao)
    {
        $sql = "SELECT id, id_treinador AS treinador,
                    id_pokemon AS pokemon, posicao
                FROM time
                WHERE id_treinador = :treinador
                AND posicao = :posicao
                ORDER BY posicao ASC";

        $stmt = self::getPDO()->prepare($sql);
        $stmt->bindParam(":treinador", $treinador);
        $stmt->bindParam(":posicao", $posicao);
        $stmt->execute();

        return $stmt->fetchObject(self::class);
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