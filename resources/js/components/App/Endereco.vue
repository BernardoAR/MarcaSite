<template>
  <div>
    <div class="form-group row">
      <div class="form-label-group col-sm-6">
        <b-form-input
          v-model="logradouro"
          type="text"
          placeholder="Logradouro"
          trim
        />
      </div>
      <div class="form-label-group col-sm-6">
        <b-form-input
          v-model="numero"
          type="number"
          placeholder="Número"
          trim
        />
      </div>
    </div>
    <div class="form-group row">
      <div class="form-label-group col-sm-6">
        <b-form-input v-model="cidade" type="text" placeholder="Cidade" trim />
      </div>
      <div class="form-label-group col-sm-6">
        <b-form-input
          v-model="uf"
          type="text"
          placeholder="UF"
          :formatter="formatUF"
          trim
        />
      </div>
    </div>
    <div class="form-group row">
      <div class="form-label-group col-sm-6">
        <b-form-input
          v-model="complemento"
          type="text"
          placeholder="Complemento"
          trim
        />
      </div>
      <div class="form-label-group col-sm-6">
        <b-form-input
          v-model="cep"
          type="text"
          placeholder="CEP"
          :formatter="formatCEP"
          trim
        />
      </div>
    </div>
  </div>
</template>
<script>
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "enderecoForm/getField",
  mutationType: "enderecoForm/updateField",
});
export default {
  methods: {
    formatUF(uf) {
      return String(uf).substring(0, 2);
    },
    regexCEP(cep) {
      return String(cep)
        .replace(/\D/g, "")
        .match(/(\d{0,5})(\d{0,3})/);
    },
    formatCEP(cep) {
      let x = this.regexCEP(cep);
      let p2 = x[2] ? `-${x[2]}` : "";
      return `${x[1]}${p2}`;
    },
    validaEndereco() {
      let erros = [];
      // Valida a parte do usuarioForm
      this.$store.state.enderecoForm.cep = this.regexCEP(
        this.$store.state.enderecoForm.cep
      )[0];
      erros = this.validacao(this.$store.state.enderecoForm, {
        logradouro: "required",
        numero: "required",
        cidade: "required",
        uf: "required|minLength:2|maxLength:2",
        cep: "required|minLength:8|maxLength:8",
      });
      erros.map((valor) => {
        this.$store.state.possuiErroForm = true;
        this.erro(valor);
      });
    },
    atualizaEndereco(dados) {
      this.$store.state.enderecoForm.id = dados.id_endereco;
      this.$store.state.enderecoForm.logradouro = dados.logradouro;
      this.$store.state.enderecoForm.numero = dados.numero;
      this.$store.state.enderecoForm.cidade = dados.cidade;
      this.$store.state.enderecoForm.uf = dados.uf;
      this.$store.state.enderecoForm.complemento = dados.complemento;
      this.$store.state.enderecoForm.cep = this.formatCEP(dados.cep);
    },
    limpaEndereco() {
      this.$store.state.enderecoForm.id = "";
      this.$store.state.enderecoForm.logradouro = "";
      this.$store.state.enderecoForm.numero = "";
      this.$store.state.enderecoForm.cidade = "";
      this.$store.state.enderecoForm.uf = "";
      this.$store.state.enderecoForm.complemento = "";
      this.$store.state.enderecoForm.cep = "";
    },
  },
  unmounted() {
    this.limpaEndereco();
  },
  computed: {
    ...mapFields({
      id: "id",
      logradouro: "logradouro",
      numero: "numero",
      cidade: "cidade",
      uf: "uf",
      complemento: "complemento",
      cep: "cep",
    }),
  },
};
</script>