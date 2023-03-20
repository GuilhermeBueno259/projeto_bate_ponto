<template>
  <div>
    <form @submit="(e) => funcaoQuandoClicar(e)" method="POST">
      <div class="form-group">
        <label for="nome">Nome:</label>
        <input class="form-control" id="nome" type="text" v-model.trim="nomeFuncionario" ref="input">
        <div v-for="error of v$.nomeFuncionario.$errors" :key="error.$uid">{{ error.$message }}</div>
      </div>
      <button class="btn btn-primary m-4" type="submit">{{ textoBotao }}</button>
      <div v-if="mensagem != ''">{{ mensagem }}</div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import { required, minLength, helpers } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';

const alpha = helpers.regex(/[a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]/);

export default {
  name: 'FormularioComponent',
  setup() {
    return {
      v$: useVuelidate()
    }
  },
  data() {
    return {
      nomeFuncionario: '',
      mensagem: ''
    }
  },
  mounted() {
    this.$refs.input.focus();
  },
  props: {
    textoBotao: String
  },
  methods: {
    async funcaoQuandoClicar(e) {
      e.preventDefault();

      const nomeValido = await this.v$.$validate();

      if (!nomeValido) return

      switch (this.textoBotao) {
        case 'Cadastrar Funcionário':
          axios({
            headers: {
              'Content-Type': 'multipart/form-data'
            },
            method: 'post',
            url: 'http://localhost/projeto_bate_ponto/back_end/ReceberRequisicoes.php?operacao=cadastrar_funcionario',
            data: {
              nomeFuncionario: this.nomeFuncionario
            }
          }).then((resposta) => {
            this.mensagem = resposta.data;
          });
          break;
        case 'Bater Ponto':
          axios({
            headers: {
              'Content-Type': 'multipart/form-data'
            },
            method: 'post',
            url: 'http://localhost/projeto_bate_ponto/back_end/ReceberRequisicoes.php?operacao=bater_ponto',
            data: {
              nomeFuncionario: this.nomeFuncionario
            }
          }).then((resposta) => {
            this.mensagem = resposta.data;
          });
          break;
      }
    },
  },
  validations: {
    nomeFuncionario: {
      required: helpers.withMessage('O nome do funcionário é obrigatório', required),
      minLength: helpers.withMessage('O nome do funcionário deve ter no mínimo 3 letras', minLength(3)),
      alpha: helpers.withMessage('Apenas letras são permitidas', alpha)
    }
  }
}
</script>