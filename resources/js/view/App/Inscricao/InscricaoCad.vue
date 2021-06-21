<template>
  <div>
    <div class="form-group">
      <b-form-select v-model="curso" :options="optionsCurso">
        <template #first>
          <b-form-select-option :value="null">-- Curso --</b-form-select-option>
        </template>
      </b-form-select>
    </div>
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
          ><usuario
            :desabilitar="desabilitarSenha"
            ref="usuario"
            @usuario-mudou="usuarioMudou"
          ></usuario>
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
      variant="outline-primary"
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
import Endereco from "../../../components/App/Endereco.vue";
import Usuario from "../../../components/App/Usuario.vue";
import Contato from "../../../components/App/Contato.vue";
export default {
  components: { Contato, Endereco, Usuario },
  async created() {
    this.getCursos();
    if (this.$route.params.id != null) {
      this.atualiza(this.$route.params.id);
    }
  },
  methods: {
    usuarioMudou(id) {
      if (id !== null) {
        this.atualiza(id);
      } else {
        this.update = false;
        this.$refs.usuario.limpaUsuario();
        this.desabilitarSenha = false;
      }
    },
    async atualiza(id) {
      this.desabilitarSenha = true;
      this.atualizarCampos([]);
      const res = await this.chamaApi(
        "get",
        `/app/usuarios/get-usuario-inscricao/${id}`,
        []
      );
      if (res.status == 200 || res.status == 201) {
        this.atualizarCampos(res.data);
      }
    },
    async getCursos() {
      this.chamaApi("get", "/app/curso/get", []).then((response) => {
        this.optionsCurso = response.data;
      });
    },
    atualizarCampos(dados) {
      this.$refs.usuario.atualizaUsuario(dados);
      this.$refs.endereco.atualizaEndereco(dados);
      this.$refs.contato.atualizaContato(dados);
    },
    limpaCampos() {
      this.$refs.usuario.limpaUsuario();
      this.$refs.endereco.limpaEndereco();
      this.$refs.contato.limpaContato();
    },
    async cadastro() {
      this.$store.state.possuiErroForm = false;
      this.$refs.usuario.validaUsuario();
      this.$refs.endereco.validaEndereco();
      this.$refs.contato.validaContato();
      this.estaCadastrando = true;

      if (!this.$store.state.possuiErroForm) {
        const res = await this.chamaApi("post", "/app/inscricao/store", {
          curso: this.curso,
          usuario: this.$store.state.usuarioForm,
          endereco: this.$store.state.enderecoForm,
          contato: this.$store.state.contatoForm,
        });
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
  unmounted() {
    this.limpaCampos();
  },
  data: function () {
    return {
      curso: null,
      desabilitarSenha: false,
      update: false,
      optionsCurso: null,
      estaCadastrando: false,
    };
  },
};
</script>