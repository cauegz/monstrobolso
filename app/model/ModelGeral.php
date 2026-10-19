<?php
/**
 * Classe model geral que contém os métodos que todas as outras devem ter, inclunindo os gets e sets mágicos, em que,
 * se for necessária alguma validação de um atributo, fazer um set no model específico
 */
abstract class ModelGeral
{
    protected static $pdo = null;

    protected ?int $id = null;

    protected static function getPDO()
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

    public function __set(string $nome, mixed $valor)
    {
        //antes de executar o set padrão verifica se tem algum explícito na classe
        $metodo = 'set' . ucfirst($nome);

        if (method_exists($this, $metodo)) {
            $this->$metodo($valor);
            return;
        }
        $this->$nome = $valor;
    }
}