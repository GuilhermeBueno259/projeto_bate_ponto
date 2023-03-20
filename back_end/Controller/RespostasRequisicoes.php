<?php
require_once PASTA_RAIZ . '/Model/Dao/PontoDao.php';
require_once PASTA_RAIZ . '/Model/Dao/FuncionarioDao.php';

class RespostasRequisicoes
{
    private $pontoDao;
    private $funcionarioDao;

    function __construct()
    {
        $this->pontoDao = new PontoDao();
        $this->funcionarioDao = new FuncionarioDao();
    }

    public function retornarTabela()
    {
        $tabela = [];

        foreach ($this->definirDatas() as $data) {
            foreach ($this->buscarFuncionarios() as $funcionario) {
                $horasTrabalhadas = $this->calcularHorasTrabalhadasNaData($funcionario, $data);
                $batimentos = $this->buscarBatimentosPorFuncionarioEData($funcionario, $data);

                $dataFormatada = new DateTime($data);

                if ($horasTrabalhadas != false && $horasTrabalhadas != '00:00') {
                    array_push($tabela, [$dataFormatada->format('d/m/y'), $funcionario, $horasTrabalhadas, $batimentos]);
                }
            }
        }

        echo json_encode($tabela);
    }
    
    public function calcularHorasTrabalhadasNaData($funcionario, $data)
    {
        $funcionarioId = $this->funcionarioDao->retornar($funcionario)->getId();
        
        $horarioDeAbrir = new DateTime($data . ' 07:30:00', HORARIO_BRASILIA);
        $horarioDeFechar =  new DateTime($data . ' 18:30:00', HORARIO_BRASILIA);
        
        $horarios = $this->pontoDao->retornarHorarioDeEntradaEDeSaida($funcionarioId, $horarioDeAbrir->format('y-m-d H:i:s'), $horarioDeFechar->format('y-m-d H:i:s'));

        if (!$horarios[0] || !$horarios[1]) {
            return false;
        } else {
            $horarioDeEntrada = new DateTime($horarios[0]['horario']);
            $horarioDeSaida = new DateTime($horarios[1]['horario']);

            $horasTrabalhadas = $horarioDeSaida->diff($horarioDeEntrada);
            return $horasTrabalhadas->format('%H:%I');
        }
    }

    public function definirDatas()
    {
        $datas = [];

        $agora = new DateTime('now', HORARIO_BRASILIA);

        for ($i = 0; $i < 7; $i++) {
            if ($i == 0) {
                array_push($datas, $agora->format('y-m-d'));
            } else {
                array_push($datas, $agora->sub(new DateInterval('P' . 1 . 'D'))->format('y-m-d'));
            }
        }

        return $datas;
    }

    public function buscarFuncionarios()
    {
        $funcionarios = [];

        foreach ($this->funcionarioDao->retornarTodos() as $value) {
            array_push($funcionarios, $value['nome']);
        }

        return $funcionarios;
    }

    public function buscarBatimentosPorFuncionarioEData($funcionario, $data)
    {
        $funcionarioId = $this->funcionarioDao->retornar($funcionario)->getId();

        return $this->pontoDao->retornarBatimentosPorDiaEFuncionario($funcionarioId, date('Y-m-d H:i:s', strtotime($data) + 3600 * 7.5), date('Y-m-d H:i:s', strtotime($data) + 3600 * 18.5));
    }

    public function cadastrarFuncionario($nomeFuncionario)
    {
        try {
            $this->funcionarioDao->cadastrar($nomeFuncionario);
        } catch (\Throwable $th) {
            echo json_encode('Erro ao cadastrar funcionário:' . $th->getMessage());
        }

        echo json_encode('Funcionário cadastrado com sucesso');
    }

    public function baterPonto($nomeFuncionario)
    {
        try {
            $funcionario = $this->funcionarioDao->retornar($nomeFuncionario);

            if ($funcionario != false) {
                $this->pontoDao->cadastrar($funcionario->getId());
            } else {
                echo json_encode('Funcionário não está cadastrado');
            }
        } catch (\Throwable $th) {
            echo json_encode('Erro ao bater o ponto: ' . $th->getMessage());
        }

        echo json_encode('Ponto batido com sucesso');
    }
}
