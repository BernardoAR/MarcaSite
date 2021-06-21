<template>
  <div>
    <modal
      titulo="Deletar Inscrição"
      texto="Deseja realmente excluir esta inscrição?"
      ok="Sim"
      cancelar="Cancelar"
      @click-ok="deletaInscricao"
    ></modal>
    <v-text-field
      v-model="pesquisa"
      append-icon="mdi-magnify"
      label="Pesquisar"
      single-line
      hide-details
    ></v-text-field>
    <v-data-table
      @current-items="valoresAtuais"
      :headers="colunas"
      :items="data"
      :loading="carregando"
      loading-text="Carregando..."
      :search="pesquisa"
    >
      <template v-slot:item="row">
        <tr>
          <td>{{ row.item.id }}</td>
          <td>{{ row.item.inscrito }}</td>
          <td>{{ row.item.data_inscricao }}</td>
          <td>{{ row.item.categoria }}</td>
          <td>{{ row.item.cpf }}</td>
          <td>{{ row.item.email }}</td>
          <td>{{ row.item.uf }}</td>
          <td :class="pegaCor(row.item.status)">
            <v-edit-dialog
              :return-value.sync="row.item.status"
              large
              persistent
              cancel-text="Cancelar"
              save-text="Salvar"
              @save="salvar(row)"
            >
              <div>{{ options[row.item.status - 1].text }}</div>
              <template v-slot:input>
                <b-form-select v-model="row.item.status" :options="options">
                  <template #first>
                    <b-form-select-option :value="null"
                      >-- Status --</b-form-select-option
                    >
                  </template>
                </b-form-select>
              </template>
            </v-edit-dialog>
          </td>
          <td>{{ row.item.total }}</td>
          <td>
            <b-button
              size="sm"
              class="mb-2"
              variant="outline-primary"
              @click="$router.push(`/inscricao/edit/${row.item.id}`)"
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

    <b-button size="sm" class="mb-2" variant="outline-primary">
      <download-csv
        :data="dataFiltrado"
        :labels="header"
        :fields="fields"
        :separator-excel="true"
      >
        Exportar CSV
      </download-csv>
    </b-button>
    <b-button
      size="sm"
      class="mb-2"
      variant="outline-primary"
      @click="exportPDF"
    >
      Exportar PDF
    </b-button>
  </div>
</template>
<script>
import jsPDF from "jspdf";
import "jspdf-autotable";

import Modal from "../../../components/Modal.vue";
export default {
  components: { Modal },
  data() {
    return {
      options: null,
      carregando: true,
      linha: null,
      pesquisa: "",
      fields: [
        "inscrito",
        "data_inscricao",
        "categoria",
        "cpf",
        "email",
        "uf",
        "status",
        "total",
      ],
      header: {
        id: "ID",
        inscrito: "Inscrito",
        data_inscricao: "Data de inscrição",
        categoria: "Categoria",
        cpf: "CPF",
        email: "E-mail",
        uf: "UF",
        status: "Status",
        total: "Total",
      },
      head: [
        "Inscrito",
        "Data de inscrição",
        "Categoria",
        "CPF",
        "E-mail",
        "UF",
        "Status",
        "Total",
      ],
      colunas: [
        { value: "id", text: "ID" },
        { value: "inscrito", text: "Inscrito" },
        { value: "data_inscricao", text: "Data de inscrição" },
        { value: "categoria", text: "Categoria" },
        { value: "cpf", text: "CPF" },
        { value: "email", text: "E-mail" },
        { value: "uf", text: "UF" },
        { value: "status", text: "Status" },
        { value: "total", text: "Total" },
        { value: "action", text: "Ações" },
      ],
      data: [],
      dataPDF: [],
      dataFiltrado: [],
    };
  },
  async created() {
    this.chamaApi("get", "/app/inscricao/get", []).then((response) => {
      this.data = response.data;
      this.carregando = false;
    });
    this.chamaApi("get", "/app/status", []).then((response) => {
      this.options = response.data;
    });
  },
  methods: {
    valoresAtuais(data) {
      this.dataFiltrado = data;
    },
    excluirClicado(row) {
      this.linha = row;
      this.$bvModal.show("modal");
    },
    async salvar(row) {
      const res = await this.chamaApi(
        "put",
        `/app/inscricao/update-status/${row.item.id}`,
        {
          status: row.item.status,
        }
      );
      if (res.status == 200 || res.status == 201) {
        this.sucesso("Status atualizado com sucesso!");
      } else {
        this.swr();
      }
    },

    pegaCor(valor) {
      switch (valor) {
        case 1:
          return "bg-danger";
        case 2:
          return "bg-warning";
        case 3:
          return "bg-success";
      }
    },
    async deletaInscricao() {
      const res = await this.chamaApi(
        "delete",
        `/app/inscricao/delete/${this.linha.item.id}`,
        []
      );
      if (res.status === 200 || res.status === 201) {
        this.sucesso("Inscrição deletada com sucesso!");
        this.data.splice(this.data.indexOf(this.linha.item), 1);
        this.linha = null;
      } else {
        this.swr();
      }
    },
    exportPDF() {
      this.adicionaCamposDataPDF();
      let doc = new jsPDF();
      doc.autoTable({ head: [this.head], body: this.dataPDF });
      doc.save("Inscricao.pdf");
    },
    adicionaCamposDataPDF() {
      this.dataPDF = [];
      for (let i in this.dataFiltrado) {
        let dado = [];
        for (let j in this.fields) {
          if (this.fields[j] == "status") {
            dado.push(
              this.options[this.dataFiltrado[i][this.fields[j]] - 1].text
            );
          } else {
            dado.push(this.dataFiltrado[i][this.fields[j]]);
          }
        }
        this.dataPDF.push(dado);
      }
    },
  },
};
</script>