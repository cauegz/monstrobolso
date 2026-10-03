<?php
class Conexao{
    public static function getPDO(){
        $host = "db";
        $porta = "5432";
        $banco = "monstrobolso";
        $usuario = "postgres";
        $senha = "postgres";
        try {
            $dsn = "pgsql:host={$host};port={$porta};dbname={$banco}";

            $conexao = new PDO($dsn, $usuario, $senha);
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //fazer isso retornar json depois, deixei isso pra debug
            echo $e;
            die();
        }
        return $conexao;
    }
}