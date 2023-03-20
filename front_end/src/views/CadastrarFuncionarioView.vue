<template>
    <FormularioComponent funcaoQuandoClicar=cadastrarFuncionario() textoBotao="Cadastrar Funcionário"/>
</template>

<script>
import FormularioComponent from '@/components/FormularioComponent.vue'

export default {
  name: 'CadastrarFuncionariosView',
  components: {
    FormularioComponent
  },
  methods: {
    cadastrarFuncionario (e) {
      e.preventDefault();
      console.log('Funcionou!');
    }
  }
}
</script>
