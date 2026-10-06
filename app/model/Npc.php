<?php

class Npc implements JsonSerializable
{
    private static $pdo;

    private ?int $id = null;
    private string $nome;
    private int $tipoNpc;

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
        $sql = "SELECT id, nome, id_tipo_npc
                FROM npc";

        if ($filter) {
            $sql .= " WHERE " . $filter;
        }

        $result = self::getPDO()->prepare($sql);

        $result->execute();

        $dados = $result->fetchAll(PDO::FETCH_ASSOC);

        $npcs = [];

        foreach ($dados as $dado) {

            $npc = new Npc();

            $npc->id = $dado['id'];
            $npc->nome = $dado['nome'];
            $npc->tipoNpc = $dado['id_tipo_npc'];

            $npcs[] = $npc;
        }

        return $npcs;
    }

    public static function delete(int $id)
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