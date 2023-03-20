<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Data</th>
                <th>Funcionario</th>
                <th>Total de Horas</th>
                <th>Batimentos</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="linha in dadosTabela" :key="linha[0]">
                <td>{{ linha[0] }}</td>
                <td>{{ linha[1] }}</td>
                <td>{{ linha[2] }}</td>
                <td>{{ linha[3] }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import axios from 'axios';

export default {
    name: "RelatorioView",
    data() {
        return {
            dadosTabela: []
        }
    },
    mounted() {
        axios({
            method: 'get',
            url: 'http://localhost/projeto_bate_ponto/back_end/ReceberRequisicoes.php?operacao=relatorio_batimentos_dia'
        }).then((response) => {
            this.dadosTabela = response.data;
        });
    }
}
</script>