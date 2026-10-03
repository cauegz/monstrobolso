<?php
class Conexao{
    /**@var PDO $conexao */
    private static $conexao;

    public static function getPDO()
    {
        if (self::$conexao === null) {
            $dsn = "pgsql:host=db;port=5432;dbname=monstrobolso";
            self::$conexao = new PDO($dsn, "postgres", "postgres");
            self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$conexao;
    }
}