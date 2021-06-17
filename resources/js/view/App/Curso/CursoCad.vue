<template>
  <div class="card mb-3">
    <div class="card-header">Cadastrar Curso</div>
    <div class="card-body">
      <div class="container">
        <div class="form-group">
          <div class="form-label-group">
            <input
              type="text"
              class="form-control"
              id="nomeCurso"
              name="nomeCurso"
              placeholder="Nome do Curso"
              v-model="data.nomeCurso"
              required
            />
            <label for="nomeCurso">Nome do Curso:</label>
          </div>
        </div>
        <div class="form-group">
          <div class="form-label-group">
            <input
              type="text"
              class="form-control"
              id="descricao"
              name="descricao"
              placeholder="Descrição"
              v-model="data.descricao"
              required
            />
            <label for="descricao">Descrição:</label>
          </div>
        </div>
        <div class="form-group">
          <div class="form-label-group">
            <input
              type="number"
              class="form-control"
              id="valor"
              name="valor"
              placeholder="Valor (em R$)"
              v-model="data.valor"
              required
            />
            <label for="valor">Valor (em R$):</label>
          </div>
        </div>
        <div class="form-group">
          <div class="form-label-group">
            <b-form-datepicker
              class="form-control"
              id="dataInicio"
              name="dataInicio"
              placeholder="Data de início das inscrições"
              v-model="data.dataInicio"
              required
            />
            <label for="dataInicio">Data de início das inscrições:</label>
          </div>
        </div>
        <div class="form-group">
          <div class="form-label-group">
            <b-form-datepicker
              type="date"
              class="form-control"
              id="dataFim"
              name="dataFim"
              placeholder="Data de término das inscrições"
              v-model="data.dataFim"
              required
            />
            <label for="dataInicio">Data de término das inscrições:</label>
          </div>
        </div>
        <div class="form-group">
          <div class="form-label-group">
            <input
              type="number"
              class="form-control"
              id="quantidade"
              name="quantidade"
              placeholder="Quantidade de Inscritos (máx)"
              v-model="data.quantidade"
              required
            />
            <label for="quantidade">Quantidade de Inscritos (máx):</label>
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
        <button type="button" class="btn btn-primary" @click="cadastra">
          Cadastrar
        </button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      data: {
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
    onFileChange(e) {
      this.data.file = e.target.files[0];
    },
    limpaCampos() {
      this.data.quantidade = "";
      this.data.nomeCurso = "";
      this.data.descricao = "";
      this.data.dataInicio = "";
      this.data.dataFim = "";
      this.data.valor = "";
      this.data.file = null;
    },
    async cadastra() {
      if (this.data.nomeCurso.trim() == "")
        return this.erro("É obrigatório o nome do curso!");
      if (this.data.descricao.trim() == "")
        return this.erro("É obrigatório a descrição do curso!");
      if (this.data.valor.trim() == "")
        return this.erro("É necessário o valor do curso!");
      if (this.data.dataInicio.trim() == "")
        return this.erro("É necessário a data de início das inscrições!");
      if (this.data.dataFim.trim() == "")
        return this.erro("É necessário a data de fim das inscrições!");
      if (this.data.quantidade.trim() == "")
        return this.erro(
          "É necessário estabelecer quantidade de inscritos máxima!"
        );
      let formData = this.objToFormData(this.data);
      const res = await this.chamaApi("post", "/app/curso/store", formData);
      if (res.status === 200) {
        this.sucesso(res.data.msg);
        this.limpaCampos();
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
    },
  },
};
</script>