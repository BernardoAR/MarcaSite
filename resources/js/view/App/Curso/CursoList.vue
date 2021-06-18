<template>
  <Table :loading="carregando" :columns="columns" :data="data">
    <template slot-scope="{ row, index }" slot="nome_curso">
      <Input
        type="text"
        v-model="valores.editNomeCurso"
        v-if="valores.editIndex === index"
      />
      <span v-else>{{ row.nome_curso }}</span>
    </template>
    <template slot-scope="{ row, index }" slot="quantidade">
      <Input
        type="text"
        v-model="valores.editQuantidade"
        v-if="valores.editIndex === index"
      />
      <span v-else>{{ row.quantidade }}</span>
    </template>
    <template slot-scope="{ row, index }" slot="descricao">
      <Input
        type="text"
        v-model="valores.editDescricao"
        v-if="valores.editIndex === index"
      />
      <span v-else>{{ row.descricao }}</span>
    </template>

    <template slot-scope="{ row, index }" slot="data_inicio">
      <Input
        type="text"
        v-model="valores.editDataInicio"
        v-if="valores.editIndex === index"
      />
      <span v-else>{{ row.data_inicio }}</span>
    </template>

    <template slot-scope="{ row, index }" slot="data_fim">
      <Input
        type="text"
        v-model="valores.editDataFim"
        v-if="valores.editIndex === index"
      />
      <span v-else>{{ row.data_fim }}</span>
    </template>

    <template slot-scope="{ row, index }" slot="valor">
      <Input
        type="number"
        v-model="valores.editValor"
        v-if="valores.editIndex === index"
      />
      <span v-else>{{ row.valor }}</span>
    </template>

    <template slot-scope="{ row, index }" slot="action">
      <div v-if="valores.editIndex === index">
        <Button @click="handleSave(index)">Salvar</Button>
        <Button @click="valores.editIndex = -1">Cancelar</Button>
      </div>
      <div v-else>
        <Button @click="handleEdit(row, index)">Editar</Button>
      </div>
    </template>
  </Table>
</template>
<script>
export default {
  data() {
    return {
      carregando: true,
      columns: [
        { slot: "nome_curso", title: "Nome" },
        { slot: "quantidade", title: "Quantidade de Inscritos (Máx)" },
        { slot: "descricao", title: "Descrição" },
        { slot: "data_inicio", title: "Data Inicial (Inscrição)" },
        { slot: "data_fim", title: "Data Final (Inscrição)" },
        { slot: "valor", title: "Valor" },
        { slot: "action", title: "Ações" },
      ],
      data: [],
      valores: {
        editIndex: -1,
        editNomeCurso: "",
        editQuantidade: "",
        editDescricao: "",
        editDataInicio: "",
        editDataFim: "",
        editValor: "",
      },
    };
  },
  async created() {
    this.chamaApi("get", "/app/curso/get", []).then((response) => {
      this.data = response.data;
      this.carregando = false;
      console.log(response.data);
    });
  },
  methods: {
    handleEdit(row, index) {
      this.valores.editNomeCurso = row.nome_curso;
      this.valores.editQuantidade = row.quantidade;
      this.valores.editDescricao = row.descricao;
      this.valores.editDataInicio = row.data_inicio;
      this.valores.editDataFim = row.data_fim;
      this.valores.editValor = row.valor;
      this.valores.editIndex = index;
    },
    handleSave(index) {
      this.data[index].nome_curso = this.valores.editNomeCurso;
      this.data[index].quantidade = this.valores.editQuantidade;
      this.data[index].descricao = this.valores.editDescricao;
      this.data[index].data_inicio = this.valores.editDataInicio;
      this.data[index].data_fim = this.valores.editDataFim;
      this.data[index].valor = this.valores.editValor;
      this.valores.editIndex = -1;
    },
  },
};
</script>