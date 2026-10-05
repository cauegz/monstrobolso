<?php
class Npc{
    private static $pdo;
    private ?int $id = null;
    private string $nome;
    private int $tipoNpc;

    public function __construct()
    {
        self::$pdo = Conexao::getPDO();
    }

    public static function find($id){
        $sql = "SELECT nome, id_tipo_npc as tipoNpc FROM npc WHERE id = :id";
        $result = self::$pdo->prepare($sql);
        $result->bindParam(":id", $id);
        $result->execute();
        return $result->fetchObject(__CLASS__);
    }

    public static function all($filter = null){
        $sql = "SELECT nome, id_tipo_npc as tipoNpc FROM npc";
        if($filter)
            $sql .= " WHERE " . $filter;

        $result = self::$pdo->prepare($sql);
        $result->execute();
        return $result->fetchALL(PDO::FETCH_CLASS, __CLASS__);
    }

    public static function delete(int $id){  
        $sql = "DELETE FROM npc WHERE id = :id";
        $result = self::$pdo->prepare($sql);             
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        $result->execute();
    }

    public function save(){
        if ($this->id == null) {

            $sql = "INSERT INTO npc (nome, id_tipo_npc)
                    VALUES (:nome, :tipoNpc)";

            $result = self::$pdo->prepare($sql);

            $result->bindParam(":nome", $this->nome);
            $result->bindParam(":tipoNpc", $this->tipoNpc);

            $result->execute();

            $this->id = self::$pdo->lastInsertId();
        } else {
            $sql = "UPDATE npc
                    SET nome = :nome, id_tipo_npc = :tipoNpc
                    WHERE id = :id";

            $result = self::$pdo->prepare($sql);

            $result->bindParam(":nome", $this->nome);
            $result->bindParam(":tipoNpc", $this->tipoNpc);
            $result->bindParam(":id", $this->id);

            $result->execute();
        }
    }
}