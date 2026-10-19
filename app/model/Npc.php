<?php

class Npc extends ModelGeral implements JsonSerializable, ModelInterface
{
    protected ?int $id = null;
    protected string $nome;
    protected int $tipoNpc;

    public static function find($id)
    {
        $sql = 'SELECT id, nome, id_tipo_npc as "tipoNpc"
                FROM npc
                WHERE id = :id';

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();

        return $result->fetchObject(self::class);
    }

    public static function all($filter = null)
    {
        $sql = 'SELECT id, nome, id_tipo_npc as "tipoNpc"
                FROM npc';

        if ($filter) {
            $sql .= " WHERE " . $filter;
        }

        $result = self::getPDO()->prepare($sql);

        $result->execute();

        return $result->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function delete($id)
    {
        $sql = "DELETE FROM npc
                WHERE id = :id";

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();
    }

    public function save()
    {
        if ($this->id == null) {

            $sql = "INSERT INTO npc (nome, id_tipo_npc)
                    VALUES (:nome, :tipoNpc)";

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":nome", $this->nome);
            $result->bindParam(":tipoNpc", $this->tipoNpc);

            $result->execute();

            $this->id = self::getPDO()->lastInsertId();

        } else {

            $sql = "UPDATE npc
                    SET nome = :nome,
                        id_tipo_npc = :tipoNpc
                    WHERE id = :id";

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":nome", $this->nome);
            $result->bindParam(":tipoNpc", $this->tipoNpc);
            $result->bindParam(":id", $this->id);

            $result->execute();
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "tipoNpc" => $this->tipoNpc
        ];
    }
}