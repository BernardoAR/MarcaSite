<template>
  <div>
    <usuario :desabilitar="desabilitarSenha" ref="usuario"></usuario>
    <button
      type="submit"
      @click="cadastro"
      :disabled="estaCadastrando"
      :loading="estaCadastrando"
      class="btn btn-primary"
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
    </button>
  </div>
</template>
<script>
import Usuario from "../../../components/App/Usuario.vue";

export default {
  watch: {
    "$store.state.usuarioForm.id": function (novoVal, antVal) {
      if (novoVal !== null) {
        this.update = true;
        this.desabilitarSenha = true;
        this.chamaApi("get", `/app/usuarios/get/${novoVal}`, []).then(
          (response) => this.atualizaCampos(response.data)
        );
      } else {
        this.update = false;
        this.$refs.usuario.limpaCampos();
        this.desabilitarSenha = false;
      }
    },
  },
  methods: {
    valida() {},
    async cadastro() {
      this.$store.state.possuiErroForm = false;
      this.$refs.usuario.valida();
      if (!this.$store.state.possuiErroForm) {
        const res = await this.chamaApi(
          "post",
          `/app/usuarios/store`,
          this.$store.state.usuarioForm
        );
        if (res.status === 200 || res.status === 201) {
          let texto = this.update ? "atualizado" : "cadastrado";
          this.sucesso(`Usuário ${texto} com sucesso!`);
          this.limpaCampos();
        } else {
          if (res.status == 422) {
            this.estaCadastrando = false;
            for (let i in res.data.errors) {
              this.e(res.data.errors[i][0]);
            }
          } else {
            this.estaCadastrando = false;
            this.swr();
          }
        }
        this.estaCadastrando = false;
      }
    },
    atualizaCampos(dados) {
      this.$refs.usuario.atualizaCampos(dados);
    },
    limpaCampos() {
      this.$refs.usuario.limpaCampos();
    },
    pegaDados() {
      console.log(this.$store.state.usuarioForm);
    },
  },

  components: { Usuario },
  data() {
    return { desabilitarSenha: false, update: false, estaCadastrando: false };
  },
};
</script>