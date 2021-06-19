<template>
  <div>
    <Table :loading="carregando" :columns="columns" :data="data" ref="table">
      <template slot-scope="{ row, index }" slot="id">
        <Input
          type="text"
          v-model="valores.editID"
          v-if="valores.editIndex === index"
          readonly
        />
        <span v-else>{{ row.id }}</span>
      </template>
      <template slot-scope="{ row, index }" slot="inscrito">
        <Input
          type="text"
          v-model="valores.editInscrito"
          v-if="valores.editIndex === index"
        />
        <span v-else>{{ row.inscrito }}</span>
      </template>
      <template slot-scope="{ row, index }" slot="data_inscricao">
        <Input
          type="text"
          v-model="valores.editDataInscricao"
          v-if="valores.editIndex === index"
        />
        <span v-else>{{ row.data_inscricao }}</span>
      </template>

      <template slot-scope="{ row, index }" slot="categoria">
        <Input
          type="text"
          v-model="valores.editCategoria"
          v-if="valores.editIndex === index"
        />
        <span v-else>{{ row.categoria }}</span>
      </template>

      <template slot-scope="{ row, index }" slot="cpf">
        <Input
          type="text"
          v-model="valores.editCpf"
          v-if="valores.editIndex === index"
        />
        <span v-else>{{ row.cpf }}</span>
      </template>

      <template slot-scope="{ row, index }" slot="email">
        <Input
          type="text"
          v-model="valores.editEmail"
          v-if="valores.editIndex === index"
        />
        <span v-else>{{ row.email }}</span>
      </template>

      <template slot-scope="{ row, index }" slot="uf">
        <Input
          type="text"
          v-model="valores.editUf"
          v-if="valores.editIndex === index"
        />
        <span v-else>{{ row.uf }}</span>
      </template>

      <template slot-scope="{ row, index }" slot="status">
        <b-form-select
          v-model="valores.editStatus"
          :options="options"
          v-if="valores.editIndex === index"
        >
        </b-form-select>
        <span v-else>{{ retornaTitulo(row.status) }}</span>
      </template>

      <template slot-scope="{ row, index }" slot="total">
        <Input
          type="number"
          v-model="valores.editTotal"
          v-if="valores.editIndex === index"
        />
        <span v-else>{{ row.total }}</span>
      </template>

      <template slot-scope="{ row, index }" slot="action">
        <div v-if="valores.editIndex === index">
          <Button @click="handleSave(index)">Salvar</Button>
          <Button @click="valores.editIndex = -1">Cancelar</Button>
        </div>
        <div v-else>
          <Button @click="handleEdit(row, index)">Editar</Button>
          <Button @click="handleDelete(row, index)">Deletar</Button>
        </div>
      </template>
    </Table>

    <Button type="primary" size="large">
      <download-csv
        :data="data"
        :labels="header"
        :fields="fields"
        :separator-excel="true"
      >
        Exportar CSV
      </download-csv></Button
    >
    <Button type="primary" size="large" @click="exportPDF">
      Exportar PDF</Button
    >
  </div>
</template>
<script>
import jsPDF from "jspdf";
import "jspdf-autotable";

const doc = new jsPDF();
export default {
  data() {
    return {
      options: null,
      carregando: true,
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
      columns: [
        {
          slot: "id",
          title: "ID",
        },
        { slot: "inscrito", title: "Inscrito" },
        { slot: "data_inscricao", title: "Data de inscrição" },
        { slot: "categoria", title: "Categoria" },
        { slot: "cpf", title: "CPF" },
        { slot: "email", title: "E-mail" },
        { slot: "uf", title: "UF" },
        {
          slot: "status",
          title: "Status",
          filters: [
            {
              label: "Cancelados",
              value: 1,
            },
            {
              label: "Aguardando Pagamento",
              value: 2,
            },
            {
              label: "Pagos",
              value: 3,
            },
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            return row.status == value;
          },
        },
        { slot: "total", title: "Total" },
        { slot: "action", title: "Ações" },
      ],
      data: [],
      dataPDF: [],
      valores: {
        editIndex: -1,
        editID: "",
        editInscrito: "",
        editDataInscricao: "",
        editCategoria: "",
        editCpf: "",
        editEmail: "",
        editUf: "",
        editStatus: "",
        editTotal: "",
      },
    };
  },
  async created() {
    this.chamaApi("get", "/app/inscricao/get", []).then((response) => {
      this.data = response.data;
      this.carregando = false;
      this.adicionaCamposDataPDF(response.data);
    });
    this.chamaApi("get", "/app/status", []).then((response) => {
      this.options = response.data;
    });
  },
  methods: {
    exportPDF() {
      doc.autoTable({ head: [this.head], body: this.dataPDF });
      doc.save("Inscricao.pdf");
    },
    adicionaCamposDataPDF(data) {
      this.dataPDF = [];
      for (let i in data) {
        let dado = [];
        for (let j in this.fields) {
          dado.push(data[i][this.fields[j]]);
        }
        this.dataPDF.push(dado);
      }
    },
    retornaTitulo(id) {
      return this.options[id - 1].text;
    },
    handleEdit(row, index) {
      this.valores.editID = row.id;
      this.valores.editInscrito = row.inscrito;
      this.valores.editDataInscricao = row.data_inscricao;
      this.valores.editCategoria = row.categoria;
      this.valores.editCpf = row.cpf;
      this.valores.editEmail = row.email;
      this.valores.editUf = row.uf;
      this.valores.editStatus = row.status;
      this.valores.editTotal = row.total;
      this.valores.editIndex = index;
    },
    async handleDelete(row, index) {
      const res = await this.chamaApi("delete", `/app/inscricao/${row.id}`, []);
      if (res.status === 200 || res.status === 201) {
        this.sucesso("Deletado com sucesso!");
        delete this.data[index];
      } else {
        this.erro("Não foi possível deletar! Tente novamente mais tarde.");
      }
    },
    handleSave(index) {
      this.data[index].id = this.valores.editID;
      this.data[index].inscrito = this.valores.editInscrito;
      this.data[index].data_inscricao = this.valores.editDataInscricao;
      this.data[index].categoria = this.valores.editCategoria;
      this.data[index].cpf = this.valores.editCpf;
      this.data[index].email = this.valores.editEmail;
      this.data[index].uf = this.valores.editUf;
      this.data[index].status = this.valores.editStatus;
      this.data[index].total = this.valores.editTotal;
      this.valores.editIndex = -1;
    },
  },
};
</script>