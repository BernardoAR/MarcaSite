<template>
  <div>
    <modal
      titulo="Deletar Usuário"
      texto="Deseja realmente excluir este curso?"
      ok="Sim"
      cancelar="Cancelar"
      @click-ok="deletaCurso"
    ></modal>
    <v-data-table
      :headers="colunas"
      :items="data"
      :loading="carregando"
      loading-text="Carregando..."
    >
      <template v-slot:item="row">
        <tr>
          <td>{{ row.item.id }}</td>
          <td>{{ row.item.nome_curso }}</td>
          <td>{{ row.item.quantidade }}</td>
          <td>{{ row.item.descricao }}</td>
          <td>{{ row.item.data_inicio }}</td>
          <td>{{ row.item.data_fim }}</td>
          <td>{{ row.item.valor }}</td>
          <td>
            <b-button
              size="sm"
              class="mb-2"
              variant="outline-primary"
              @click="$router.push(`/curso/edit/${row.item.id}`)"
            >
              <b-icon icon="pencil" aria-hidden="true"></b-icon>
            </b-button>
            <b-button
              size="sm"
              class="mb-2"
              variant="outline-primary"
              @click="excluirClicado(row)"
            >
              <b-icon icon="trash" aria-hidden="true"></b-icon>
            </b-button>
          </td>
        </tr>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import Modal from "../../../components/Modal.vue";
export default {
  components: { Modal },
  data() {
    return {
      linha: null,
      carregando: true,
      colunas: [
        { value: "id", text: "ID" },
        { value: "nome_curso", text: "Nome" },
        { value: "quantidade", text: "Quantidade de Inscritos (Máx)" },
        { value: "descricao", text: "Descrição" },
        { value: "data_inicio", text: "Data Inicial (Inscrição)" },
        { value: "data_fim", text: "Data Final (Inscrição)" },
        { value: "valor", text: "Valor" },
        { value: "action", text: "Ações" },
      ],
      data: [],
    };
  },
  async created() {
    this.carregando = true;
    this.chamaApi("get", "/app/curso/", []).then((response) => {
      this.data = response.data;
      this.carregando = false;
    });
  },
  methods: {
    async deletaCurso() {
      const res = await this.chamaApi(
        "delete",
        `/app/curso/delete/${this.linha.item.id}`,
        []
      );
      if (res.status === 200 || res.status === 201) {
        this.sucesso("Curso deletado com sucesso!");
        this.data.splice(this.data.indexOf(this.linha.item), 1);
        this.linha = null;
      } else {
        this.swr();
      }
    },
    excluirClicado(row) {
      this.linha = row;
      this.$bvModal.show("modal");
    },
  },
};
</script>