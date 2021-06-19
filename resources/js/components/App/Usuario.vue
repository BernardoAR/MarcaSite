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
        <input
          v-model="nome"
          type="text"
          class="form-control"
          id="nome"
          name="nome"
          placeholder="Nome"
          required
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
        <input
          v-model="empresa"
          type="text"
          class="form-control"
          id="empresa"
          name="empresa"
          placeholder="Empresa"
        />
      </div>

      <div class="form-label-group col-sm-6">
        <b-form-select v-model="tipoUsuario" :options="optionsTipoUsuario">
          <template #first>
            <b-form-select-option :value="null" disabled
              >-- Profissão --</b-form-select-option
            >
          </template>
        </b-form-select>
      </div>
    </div>
    <div class="form-group row">
      <div class="form-label-group col-sm-6">
        <b-form-select v-model="cargo" :options="optionsCargo">
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
    this.getCargos();
    this.getProfissoes();
  },
  methods: {
    atualizaCampos(teste) {},
    async getUsuarios() {
      this.chamaApi("get", "/app/usuarios/", []).then((response) => {
        this.optionsUsuario = response.data;
      });
    },
    async getCargos() {
      this.chamaApi("get", "/api/cargo-usuario", []).then((response) => {
        this.optionsCargo = response.data;
      });
    },
    async getProfissoes() {
      this.chamaApi("get", "/app/tipo-usuario/get", []).then((response) => {
        this.optionsTipoUsuario = response.data;
      });
    },
  },
  computed: {
    ...mapFields({
      id: "id",
      nome: "nome",
      email: "email",
      empresa: "empresa",
      senha: "senha",
      confSenha: "confSenha",
      cargo: "cargo",
      tipoUsuario: "dadosUsuarioForm.tipoUsuario",
    }),
  },
  data: function () {
    return {
      optionsTipoUsuario: null,
      optionsCargo: null,
      optionsUsuario: null,
    };
  },
};
</script>