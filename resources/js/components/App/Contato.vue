<template>
  <div>
    <div class="form-group row">
      <div class="form-label-group col-sm-6">
        <b-form-input
          v-model="telefone"
          type="tel"
          placeholder="Telefone"
          :formatter="formatContato"
          trim
        />
      </div>
      <div class="form-label-group col-sm-6">
        <b-form-input
          v-model="celular"
          type="tel"
          placeholder="Celular"
          :formatter="formatContato"
          trim
        />
      </div>
    </div>
  </div>
</template>
<script>
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "contatoForm/getField",
  mutationType: "contatoForm/updateField",
});
export default {
  methods: {
    valida() {
      this.$store.state.enderecoForm.cep = this.regexContato(
        this.$store.state.enderecoForm.cep
      )[0];
    },
    regexContato(contato) {
      return String(contato)
        .replace(/\D/g, "")
        .match(/(\d{0,2})(\d{0,4})(\d{0,1})(\d{0,4})/);
    },
    formatContato(contato) {
      let x = this.regexContato(contato);
      let p =
        x[4].length == 4
          ? `${x[3]}-${x[4]}`
          : x[4]
          ? `-${x[3]}${x[4]}`
          : x[3]
          ? `-${x[3]}`
          : "";
      return !x[2] ? x[1] : `(${x[1]}) ${x[2]}${p}`;
    },
    atualizaCampos(dados) {
      this.$store.state.contatoForm.telefone = this.formatContato(
        dados.telefone
      );
      this.$store.state.contatoForm.celular = this.formatContato(dados.celular);
    },
    limpaCampos() {
      this.$store.state.contatoForm.telefone = "";
      this.$store.state.contatoForm.celular = "";
    },
  },
  unmounted() {
    this.limpaCampos();
  },
  computed: {
    ...mapFields({
      telefone: "telefone",
      celular: "celular",
    }),
  },
};
</script>