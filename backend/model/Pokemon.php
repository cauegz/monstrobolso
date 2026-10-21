<?php

class Pokemon extends ModelGeral implements JsonSerializable, ModelInterface
{
    protected int $pokeApi;

    //status
    protected int $hp = 0;
    protected int $ataque = 0;
    protected int $ataqueEspecial = 0;
    protected int $defesa = 0;
    protected int $defesaEspecial = 0;
    protected int $velocidade = 0;

    //chaves estrangeiras
    protected ?int $efeito = null;
    protected int $treinador;

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

    public static function delete($id)
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

    public static function findByPokeApiAndTreinador($pokeApi, $treinador){
        $sql = 'SELECT id, hp, ataque, defesa, velocidade, 
                    id_pokeapi as "pokeApi", 
                    id_efeito as "efeito",
                    id_treinador as "treinador",
                    ataque_especial as "ataqueEspecial",
                    defesa_especial as "defesaEspecial" 
                FROM 
                    pokemon 
                WHERE 
                    id_pokeapi = :pokeApi AND 
                    id_treinador = :treinador';

        $stmt = self::getPDO()->prepare($sql);
        $stmt->bindParam(":pokeApi", $pokeApi);
        $stmt->bindParam(":treinador", $treinador);
        $stmt->execute();

        return $stmt->fetchObject(self::class);
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