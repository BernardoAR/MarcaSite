<template>
  <div>
    <modal
      titulo="Deletar Usuário"
      texto="Deseja realmente excluir este usuário?"
      ok="Sim"
      cancelar="Cancelar"
      @click-ok="deletaUsuario"
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
          <td>{{ row.item.nome }}</td>
          <td>{{ row.item.email }}</td>
          <td>{{ row.item.tipo }}</td>
          <td>
            <b-button
              size="sm"
              class="mb-2"
              variant="outline-primary"
              @click="$router.push(`/usuario/edit/${row.item.id}`)"
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
  created() {
    this.carregando = true;
    this.chamaApi("get", "/app/usuarios/get ", []).then((response) => {
      this.data = response.data;
      this.carregando = false;
    });
  },
  methods: {
    async deletaUsuario() {
      const res = await this.chamaApi(
        "delete",
        `/app/usuarios/delete/${this.linha.item.id}`,
        []
      );
      if (res.status === 200 || res.status === 201) {
        this.sucesso("Usuário deletado com sucesso!");
        this.data.splice(this.data.indexOf(this.linha.item), 1);
        this.linha = null;
      } else {
        if (res.status == 422) {
          for (let i in res.data.errors) {
            this.e(res.data.errors[i][0]);
          }
        } else {
          this.swr();
        }
      }
    },
    excluirClicado(row) {
      this.linha = row;
      this.$bvModal.show("modal");
    },
  },
  data() {
    return {
      linha: null,
      carregando: false,
      colunas: [
        { text: "ID", value: "id" },
        {
          text: "Nome",
          value: "nome",
        },
        {
          text: "E-mail",
          value: "email",
        },
        { text: "Tipo", value: "tipo" },
        { text: "Ações", value: "actions", sortable: false },
      ],
      data: [],
    };
  },
};
</script>