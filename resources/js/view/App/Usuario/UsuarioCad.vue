<template>
  <div>
    <usuario :desabilitar="desabilitarSenha" ref="usuario"></usuario>
    <b-button
      variant="outline-primary"
      type="submit"
      @click="cadastro"
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
</template>
<script>
import Usuario from "../../../components/App/Usuario.vue";

export default {
  created() {
    if (this.$route.params.id != null) {
      this.atualiza(this.$route.params.id);
    }
  },
  unmounted() {
    this.limpaCampos();
  },
  watch: {
    "$store.state.usuarioForm.id": function (novoVal, antVal) {
      if (novoVal !== null) {
        this.atualiza(novoVal);
      } else {
        this.update = false;
        this.$refs.usuario.limpaCampos();
        this.desabilitarSenha = false;
      }
    },
  },
  methods: {
    atualiza(id) {
      this.update = true;
      this.desabilitarSenha = true;
      this.chamaApi("get", `/app/usuarios/get/${id}`, []).then((response) =>
        this.atualizaCampos(response.data)
      );
    },
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
          this.$router.push({ path: "/usuario/list" });
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
  },
  components: { Usuario },
  data() {
    return { desabilitarSenha: false, update: false, estaCadastrando: false };
  },
};
</script>