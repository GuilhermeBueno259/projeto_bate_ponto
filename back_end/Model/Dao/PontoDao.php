<?php
require_once PASTA_RAIZ . '/Controller/Conexao.php';
require_once PASTA_RAIZ . '/Model/Ponto.php';

class PontoDao
{

    private $conexao;

    function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function cadastrar($funcionarioId)
    {
        $comando = 'INSERT INTO pontos (horario, funcionarios_id) VALUES (NOW(), :funcionarios_id)';
        $retorno = $this->conexao->prepare($comando);
        $retorno->bindValue(':funcionarios_id', $funcionarioId);
        $retorno->execute();
    }

    public function retornarPorFuncionario($funcionarioId)
    {
        $comando = 'SELECT * FROM pontos WHERE funcionarioId = :funcionarioId';
        $retorno = $this->conexao->prepare($comando);
        $retorno->bindValue(':funcionarioId', $funcionarioId);
        $retorno->execute();
    }

    public function retornarTodos()
    {
        $comando = 'SELECT * FROM pontos';
        $retorno = $this->conexao->query($comando);
        $retorno->execute();
        $retorno->setFetchMode(PDO::FETCH_BOTH);

        $matrizRetornoBusca = $retorno->fetchAll();

        $matrizRetorno = [];

        for ($i = 0; $i < $retorno->rowCount(); $i++) {
            array_push($matrizRetorno, new Ponto($matrizRetornoBusca[$i]['id'], strtotime($matrizRetornoBusca[$i]['horario']), $matrizRetornoBusca[$i]['funcionarios_id']));
        }

        return $matrizRetorno;
    }

    public function retornarBatimentosPorDiaEFuncionario($funcionarioId, $inicioDoDia, $fimDoDia)
    {
        $comando = 'SELECT COUNT(*) FROM pontos WHERE funcionarios_id = :funcionariosId AND horario BETWEEN :inicioDoDia AND :fimDoDia';
        $retorno = $this->conexao->prepare($comando);
        $retorno->bindValue(':funcionariosId', $funcionarioId);
        $retorno->bindValue(':inicioDoDia', $inicioDoDia);
        $retorno->bindValue(':fimDoDia', $fimDoDia);
        $retorno->execute();
        return $retorno->fetch()[0];
    }

    public function retornarHorarioDeEntradaEDeSaida($funcionarioId, $inicioDoDia, $fimDoDia)
    {
        $matrizRetorno = [];

        $comando = 'SELECT horario FROM pontos WHERE funcionarios_id = :funcionariosId AND horario BETWEEN :inicioDoDia AND :fimDoDia';
        $resultado = $this->conexao->prepare($comando);
        $resultado->bindValue(':funcionariosId', $funcionarioId);
        $resultado->bindValue(':inicioDoDia', $inicioDoDia);
        $resultado->bindValue(':fimDoDia', $fimDoDia);
        $resultado->execute();
        array_push($matrizRetorno, $resultado->fetch(PDO::FETCH_ASSOC));

        $comando = 'SELECT horario FROM pontos WHERE funcionarios_id = :funcionariosId AND horario BETWEEN :inicioDoDia AND :fimDoDia ORDER BY id DESC';
        $resultado = $this->conexao->prepare($comando);
        $resultado->bindValue(':funcionariosId', $funcionarioId);
        $resultado->bindValue(':inicioDoDia', $inicioDoDia);
        $resultado->bindValue(':fimDoDia', $fimDoDia);
        $resultado->execute();
        array_push($matrizRetorno, $resultado->fetch(PDO::FETCH_ASSOC));

        return $matrizRetorno;
    }
}
