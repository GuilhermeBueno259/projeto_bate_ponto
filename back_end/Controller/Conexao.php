<?php

class Conexao
{

    private static $conexao;

    public static function getConexao()
    {
        if (!isset(self::$conexao))
            self::$conexao = new PDO("mysql:host=localhost; port=3306; dbname=projeto_bate_ponto", "root", "");

        return self::$conexao;
    }
}
