<?php
class Treinador extends ModelGeral implements JsonSerializable, ModelInterface
{
    protected ?int $usuario;
    protected ?int $npc;

    public static function find($id)
    {
        $sql = 'SELECT 
                    id,
                    id_npc as "npc",
                    id_usuario as "usuario"
                FROM treinador
                WHERE id = :id';

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();

        return $result->fetchObject(self::class);
    }

    public static function all($filter = null)
    {
        $sql = 'SELECT 
                    id,
                    id_npc as "npc",
                    id_usuario as "usuario"
                FROM treinador';

        if ($filter) {
            $sql .= " WHERE " . $filter;
        }

        $result = self::getPDO()->prepare($sql);

        $result->execute();

        return $result->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function delete($id)
    {
        $sql = "DELETE FROM treinador
                WHERE id = :id";

        $result = self::getPDO()->prepare($sql);

        $result->bindParam(":id", $id);

        $result->execute();
    }

    public function save()
    {
        if ($this->id == null) {

            $sql = "INSERT INTO treinador (id_npc, id_usuario)
                    VALUES (:npc, :usuario)";

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":npc", $this->npc);
            $result->bindParam(":usuario", $this->usuario);

            $result->execute();
        
            $this->id = self::getPDO()->lastInsertId();
        } else {

            $sql = 'UPDATE treinador
                    SET id_npc = :npc,
                        id_usuario = :usuario
                    WHERE id = :id';

            $result = self::getPDO()->prepare($sql);

            $result->bindParam(":npc", $this->npc);
            $result->bindParam(":usuario", $this->usuario);
            $result->bindParam(":id", $this->id);

            $result->execute();
        }
    }

    public static function findByUsuario($usuario)
    {
        $stmt = self::getPDO()->prepare(
            'SELECT 
                id,
                id_usuario as "usuario",
                id_npc as "npc"
            FROM treinador WHERE id_usuario = :usuario'
        );
        $stmt->execute([':usuario' => $usuario]);
        return $stmt->fetchObject(self::class); // false se não existir
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id"    => $this->id,
            "npc" => $this->npc,
            "usuario"  => $this->usuario
        ];
    }
}