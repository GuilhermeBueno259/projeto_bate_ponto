import { createRouter, createWebHashHistory } from 'vue-router'
import Relatorio from '../views/Relatorio.vue';
import CadastrarFuncionarioView from '../views/CadastrarFuncionarioView.vue';
import BaterPontoView from '../views/BaterPontoView.vue';

const routes = [
  {
    path: '/',
    name: 'RelatorioView',
    component: Relatorio
  },
  {
    path: '/cadastrar-funcionario',
    name: 'CadastrarFuncionarioView',
    component: CadastrarFuncionarioView
  },
  {
    path: '/bater-ponto',
    name: 'BaterPontoView',
    component: BaterPontoView
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
