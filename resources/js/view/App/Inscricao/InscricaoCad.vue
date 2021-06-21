<template>
  <div>
    <b-card no-body class="mb-1">
      <b-button
        block
        v-b-toggle.accordion-usuario
        variant="outline-secondary"
        class="text-left"
        >Usuário</b-button
      >
      <b-collapse id="accordion-usuario" role="tabpanel" visible>
        <b-card-body
          ><usuario :desabilitar="desabilitarSenha" ref="usuario"></usuario>
        </b-card-body>
      </b-collapse>
    </b-card>
    <b-card no-body class="mb-1">
      <b-button
        block
        v-b-toggle.accordion-endereco
        variant="outline-secondary"
        class="text-left"
        >Endereço</b-button
      >
      <b-collapse id="accordion-endereco" visible>
        <b-card-body><endereco ref="endereco"></endereco> </b-card-body>
      </b-collapse>
    </b-card>
    <b-card no-body class="mb-1">
      <b-button
        block
        v-b-toggle.accordion-telefone
        variant="outline-secondary"
        class="text-left"
        >Contato</b-button
      >
      <b-collapse id="accordion-telefone" visible>
        <b-card-body><contato ref="contato"></contato> </b-card-body>
      </b-collapse>
    </b-card>
    <b-button
      type="submit"
      @click="cadastro"
      :disabled="estaCadastrando"
      :loading="estaCadastrando"
      variant="primary"
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
import Endereco from "../../../components/App/Endereco.vue";
import Usuario from "../../../components/App/Usuario.vue";
import Contato from "../../../components/App/Contato.vue";
export default {
  components: { Contato, Endereco, Usuario },
  async created() {
    this.getCursos();
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
    async getCursos() {
      this.chamaApi("get", "/app/curso/get", []).then((response) => {
        this.optionsCurso = response.data;
      });
    },
    atualizaCampos(dados) {
      this.$refs.usuario.atualizaCampos(dados);
      this.$refs.endereco.atualizaCampos(dados);
      this.$refs.contato.atualizaCampos(dados);
    },
    limpaCampos() {
      this.$refs.usuario.limpaCampos();
      this.$refs.endereco.limpaCampos();
      this.$refs.contato.limpaCampos();
    },
    async cadastro() {
      this.$store.state.possuiErroForm = false;
      this.$refs.usuario.valida();
      this.$refs.endereco.valida();
      this.estaCadastrando = true;

      if (!this.$store.state.possuiErroForm) {
        const res = await this.chamaApi(
          "post",
          "/app/inscricao/store",
          this.data
        );
        if (res.status === 200 || res.status === 201) {
          let texto = this.update ? "atualizadoa" : "cadastrada";
          this.sucesso(`Inscrição ${texto} com sucesso!`);
          this.limpaCampos();
          this.$router.push({ path: "/inscricao/list" });
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
      this.estaCadastrando = false;
    },
  },
  data: function () {
    return {
      desabilitarSenha: false,
      update: false,
      optionsCurso: null,
      estaCadastrando: false,
    };
  },
};
</script>