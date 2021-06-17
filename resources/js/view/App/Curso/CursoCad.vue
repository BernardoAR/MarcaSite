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
            <input
              type="date"
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
            <input
              type="date"
              class="form-control"
              id="dataFim"
              name="dataFim"
              placeholder="Data de término das inscrições"
              v-model="data.dataInicio"
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
        <button type="button" class="btn btn-primary" @click="teste">
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
      file: null,
      data: {
        quantidade: "",
        nomeCurso: "",
        descricao: "",
        dataInicio: "",
        dataFim: "",
        valor: "",
      },
    };
  },
  methods: {
    onFileChange(e) {
      this.file = e.target.files[0];
    },
    async cadastra() {
      let formData = new FormData();
      formData.append("file", this.file);
      await this.chamaApi("post", "/api/arquivo/upload", formData);
    },
  },
};
</script>