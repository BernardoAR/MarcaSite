<template>
  <div>
    <div>
      <div class="form-group">
        <div class="row">
          <div class="form-label-group col-sm-6">
            <b-form-input
              type="text"
              id="nomeCurso"
              name="nomeCurso"
              placeholder="Nome do Curso"
              v-model="data.nomeCurso"
              trim
            />
          </div>
          <div class="form-label-group col-sm-6">
            <b-form-input
              type="number"
              id="quantidade"
              name="quantidade"
              placeholder="Quantidade de Inscritos (máx)"
              v-model="data.quantidade"
              trim
            />
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-label-group">
          <b-form-input
            type="text"
            id="descricao"
            name="descricao"
            placeholder="Descrição"
            v-model="data.descricao"
            trim
          />
        </div>
      </div>
      <div class="form-group">
        <div class="form-label-group">
          <b-form-input
            type="number"
            id="valor"
            name="valor"
            placeholder="Valor (em R$)"
            v-model="data.valor"
            trim
          />
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <div class="form-label-group col-sm-6">
            <b-form-datepicker
              id="dataInicio"
              name="dataInicio"
              placeholder="Data de início das inscrições"
              v-model="data.dataInicio"
              trim
            />
          </div>
          <div class="form-label-group col-sm-6">
            <b-form-datepicker
              type="date"
              id="dataFim"
              name="dataFim"
              placeholder="Data de término das inscrições"
              v-model="data.dataFim"
              trim
            />
          </div>
        </div>
      </div>
      <div class="form-group">
        <b-form-file
          accept="image/*, .pdf, .zip, .ppt, .pptx, .zip, .rar"
          v-on:change="onFileChange"
          placeholder="Arquivo (Material)"
          drop-placeholder="Solte o arquivo aqui..."
        ></b-form-file>
      </div>
      <div class="mt-3">
        <b-button
          variant="outline-primary"
          @click="download"
          v-if="data.nameFile && !data.file"
        >
          <b-icon icon="download"></b-icon> Baixar Arquivo ({{
            data.nameFile
          }})</b-button
        >
        <label v-else>
          Arquivo selecionado: {{ data.file ? data.file.name : "" }}</label
        >
      </div>
      <b-button
        @click="cadastra"
        variant="outline-primary"
        :disabled="estaCadastrando"
        :loading="estaCadastrando"
        class="mt-4"
      >
        {{
          update
            ? estaCadastrando
              ? "Atualizando..."
              : "Atualizar"
            : estaCadastrando
            ? "Cadastrando..."
            : "Cadastrar"
        }}
      </b-button>
    </div>
  </div>
</template>
<script>
export default {
  created() {
    if (this.$route.params.id != null) {
      this.atualiza(this.$route.params.id);
    }
  },
  data: function () {
    return {
      update: false,
      estaCadastrando: false,
      data: {
        id: "",
        idFile: "",
        pathFile: "",
        nameFile: "",
        quantidade: "",
        nomeCurso: "",
        descricao: "",
        dataInicio: "",
        dataFim: "",
        valor: "",
        file: null,
      },
    };
  },
  methods: {
    download() {
      this.chamaApi(
        "post",
        `/app/material/download`,
        { caminho: this.data.pathFile, nome: this.data.nameFile },
        {
          responseType: "blob",
        }
      ).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", `${this.data.nameFile}`);
        document.body.appendChild(link);
        link.click();
      });
    },
    atualiza(id) {
      this.update = true;
      this.desabilitarSenha = true;
      this.chamaApi("get", `/app/curso/getCurso/${id}`, []).then((response) =>
        this.atualizaCampos(response.data)
      );
    },
    atualizaCampos(dados) {
      this.data.id = dados.id;
      this.data.idFile = dados.materiais_id ?? "";
      this.data.pathFile = dados.caminho ?? "";
      this.data.nameFile = dados.nome_material ?? "";
      this.data.quantidade = dados.quantidade;
      this.data.nomeCurso = dados.nome_curso;
      this.data.descricao = dados.descricao;
      this.data.dataInicio = dados.data_inicio;
      this.data.dataFim = dados.data_fim;
      this.data.valor = dados.valor;
    },
    onFileChange(e) {
      this.data.file = e.target.files[0];
    },
    limpaCampos() {
      this.data.id = "";
      this.data.idFile = "";
      this.data.pathFile = "";
      this.data.nameFile = "";
      this.data.quantidade = "";
      this.data.nomeCurso = "";
      this.data.descricao = "";
      this.data.dataInicio = "";
      this.data.dataFim = "";
      this.data.valor = "";
      this.data.file = null;
    },
    valida() {
      let erros = [];
      // Valida a parte do formulario
      erros = this.validacao(this.data, {
        quantidade: "required|greaterEqual:1",
        nomeCurso: "required",
        descricao: "required",
        dataInicio: "required",
        dataFim: "required",
        valor: "required|greaterEqual:0",
      });
      erros.map((valor) => {
        this.$store.state.possuiErroForm = true;
        this.erro(valor);
      });
    },
    async cadastra() {
      this.$store.state.possuiErroForm = false;
      this.valida();
      if (!this.$store.state.possuiErroForm) {
        let formData = this.objToFormData(this.data);
        const res = await this.chamaApi(
          "post",
          "/app/curso/store-update",
          formData
        );
        if (res.status === 200) {
          this.sucesso(res.data.msg);
          this.$router.push({ path: "/curso/list" });
        } else {
          if (res.status === 401) {
            this.erro(res.data.msg);
          } else if (res.status === 422) {
            for (let i in res.data.errors) {
              this.erro(res.data.errors[i][0]);
            }
          } else {
            this.swr();
          }
        }
      }
    },
  },
};
</script>