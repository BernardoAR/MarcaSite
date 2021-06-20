<template>
  <div>
    <div class="form-group">
      <b-form-select v-model="id" :options="optionsUsuario">
        <template #first>
          <b-form-select-option :value="null"
            >-- Novo Usuário --</b-form-select-option
          >
        </template>
      </b-form-select>
    </div>
    <div class="form-group row">
      <div class="form-label-group col-sm-6">
        <b-form-input
          v-model="nome"
          type="text"
          id="nome"
          name="nome"
          placeholder="Nome"
          trim
        />
      </div>
      <div class="form-label-group col-sm-6">
        <input
          v-model="email"
          type="email"
          class="form-control"
          id="email"
          name="email"
          placeholder="E-mail"
          required
        />
      </div>
    </div>
    <div class="form-group row">
      <div class="form-label-group col-sm-6">
        <input
          v-model="cpf"
          type="number"
          class="form-control"
          id="cpf"
          name="cpf"
          placeholder="CPF"
          required
        />
      </div>
      <div class="form-label-group col-sm-6">
        <input
          v-model="empresa"
          type="text"
          class="form-control"
          id="empresa"
          name="empresa"
          placeholder="Empresa"
        />
      </div>
    </div>
    <div class="form-group row">
      <div class="form-label-group col-sm-6">
        <input
          :disabled="desabilitar"
          v-model="senha"
          type="password"
          class="form-control"
          id="senha"
          name="senha"
          placeholder="Senha"
          required
        />
      </div>
      <div class="form-label-group col-sm-6">
        <input
          :disabled="desabilitar"
          v-model="confSenha"
          type="password"
          class="form-control"
          id="confSenha"
          name="confSenha"
          placeholder="Confirmar Senha"
          required
        />
      </div>
    </div>
    <div class="form-group row">
      <div class="form-label-group col-sm-6">
        <b-form-select v-model="profissao" :options="optionsProfissao">
          <template #first>
            <b-form-select-option :value="null" disabled
              >-- Profissão --</b-form-select-option
            >
          </template>
        </b-form-select>
      </div>
      <div class="form-label-group col-sm-6">
        <b-form-select v-model="tipo" :options="optionsTipo">
          <template #first>
            <b-form-select-option :value="null" disabled
              >-- Tipo --</b-form-select-option
            >
          </template>
        </b-form-select>
      </div>
    </div>
  </div>
</template>
<script>
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "usuarioForm/getField",
  mutationType: "usuarioForm/updateField",
});
export default {
  async created() {
    this.getUsuarios();
    this.getTipos();
    this.getProfissoes();
  },
  props: ["desabilitar"],
  methods: {
    valida() {
      let erros = [];
      // Valida a parte do usuarioForm
      erros = this.validacao(this.$store.state.usuarioForm, {
        email: "required|email",
        nome: "required",
        tipo: "required",
      });
      // Verifica se está desabilitado
      if (!this.desabilitar) {
        erros = erros.concat(
          this.validacao(this.$store.state.usuarioForm, {
            senha: "required|minLength:8|match:confSenha",
          })
        );
      }
      erros = erros.concat(
        this.validacao(this.$store.state.usuarioForm.dadosUsuario, {
          cpf: "required|minLength:11|maxLength:11",
          empresa: "required",
          profissao: "required",
        })
      );
      erros.map((valor) => {
        this.$store.state.possuiErroForm = true;
        this.erro(valor);
      });
    },
    atualizaCampos(dados) {
      this.$store.state.usuarioForm.id = dados.id;
      this.$store.state.usuarioForm.email = dados.email;
      this.$store.state.usuarioForm.tipo = dados.cargo_usuarios_id;
      this.$store.state.usuarioForm.nome = dados.nome;
      this.$store.state.usuarioForm.dadosUsuario.cpf = dados.cpf ?? "";
      this.$store.state.usuarioForm.dadosUsuario.empresa = dados.empresa ?? "";
      this.$store.state.usuarioForm.dadosUsuario.profissao =
        dados.tipo_usuarios_id ?? null;
    },
    limpaCampos() {
      this.$store.state.usuarioForm.id = null;
      this.$store.state.usuarioForm.email = "";
      this.$store.state.usuarioForm.tipo = null;
      this.$store.state.usuarioForm.nome = "";
      this.$store.state.usuarioForm.senha = "";
      this.$store.state.usuarioForm.confSenha = "";
      this.$store.state.usuarioForm.dadosUsuario.cpf = "";
      this.$store.state.usuarioForm.dadosUsuario.empresa = "";
      this.$store.state.usuarioForm.dadosUsuario.profissao = null;
    },
    getUsuarios() {
      this.chamaApi("get", "/app/usuarios/", []).then((response) => {
        this.optionsUsuario = response.data;
      });
    },
    getTipos() {
      this.chamaApi("get", "/api/cargo-usuario", []).then((response) => {
        this.optionsTipo = response.data;
      });
    },
    getProfissoes() {
      this.chamaApi("get", "/app/tipo-usuario/get", []).then((response) => {
        this.optionsProfissao = response.data;
      });
    },
  },
  unmounted() {
    this.limpaCampos();
  },
  computed: {
    ...mapFields({
      id: "id",
      nome: "nome",
      email: "email",
      senha: "senha",
      confSenha: "confSenha",
      tipo: "tipo",
      empresa: "dadosUsuario.empresa",
      cpf: "dadosUsuario.cpf",
      profissao: "dadosUsuario.profissao",
    }),
  },
  data: function () {
    return {
      optionsProfissao: null,
      optionsTipo: null,
      optionsUsuario: null,
    };
  },
};
</script>