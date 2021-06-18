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
        <b-card-body>
          <div class="form-group">
            <b-form-select v-model="data.id" :options="optionsUsuario">
              <template #first>
                <b-form-select-option :value="null"
                  >Novo Usuário</b-form-select-option
                >
              </template>
            </b-form-select>
          </div>
          <div class="form-group row">
            <div class="form-label-group col-sm-6">
              <input
                v-model="data.usuario.dadosUsuario.nome"
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
                v-model="data.usuario.email"
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
                v-model="data.usuario.senha"
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
                v-model="data.usuario.confSenha"
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
                v-model="data.usuario.dadosUsuario.empresa"
                type="text"
                class="form-control"
                id="empresa"
                name="empresa"
                placeholder="Empresa"
                required
              />
            </div>

            <div class="form-label-group col-sm-6">
              <b-form-select
                v-model="data.usuario.dadosUsuario.tipoUsuario"
                :options="optionsTipoUsuario"
              >
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
              <b-form-select
                v-model="data.usuario.cargo"
                :options="optionsCargo"
              >
                <template #first>
                  <b-form-select-option :value="null" disabled
                    >-- Tipo --</b-form-select-option
                  >
                </template>
              </b-form-select>
            </div>
            <div class="form-label-group col-sm-6">
              <b-form-select
                v-model="data.usuario.curso"
                :options="optionsCurso"
              >
                <template #first>
                  <b-form-select-option :value="null" disabled
                    >-- Curso --</b-form-select-option
                  >
                </template>
              </b-form-select>
            </div>
          </div>
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
        <b-card-body>
          <div class="form-group row">
            <div class="form-label-group col-sm-6">
              <input
                v-model="data.endereco.logradouro"
                type="text"
                class="form-control"
                id="logradouro"
                name="logradouro"
                placeholder="Logradouro"
                required
              />
            </div>
            <div class="form-label-group col-sm-6">
              <input
                v-model="data.endereco.numero"
                type="number"
                class="form-control"
                id="numero"
                name="numero"
                placeholder="Número"
                required
              />
            </div>
          </div>
          <div class="form-group row">
            <div class="form-label-group col-sm-6">
              <input
                v-model="data.endereco.cidade"
                type="text"
                class="form-control"
                id="cidade"
                name="cidade"
                placeholder="Cidade"
                required
              />
            </div>
            <div class="form-label-group col-sm-6">
              <input
                v-model="data.endereco.uf"
                type="text"
                class="form-control"
                id="uf"
                name="uf"
                placeholder="UF"
                required
              />
            </div>
          </div>
          <div class="form-group row">
            <div class="form-label-group col-sm-6">
              <input
                v-model="data.endereco.complemento"
                type="text"
                class="form-control"
                id="complemento"
                name="complemento"
                placeholder="Complemento"
                required
              />
            </div>
            <div class="form-label-group col-sm-6">
              <input
                v-model="data.endereco.cep"
                type="number"
                class="form-control"
                id="cep"
                name="cep"
                placeholder="CEP"
                required
              />
            </div>
          </div>
        </b-card-body>
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
        <b-card-body>
          <div class="form-group row">
            <div class="form-label-group col-sm-6">
              <input
                v-model="data.contato.telefone"
                type="number"
                class="form-control"
                id="telefone"
                name="telefone"
                placeholder="Telefone"
                required
              />
            </div>
            <div class="form-label-group col-sm-6">
              <input
                v-model="data.contato.celular"
                type="number"
                class="form-control"
                id="celular"
                name="celular"
                placeholder="Celular"
                required
              />
            </div>
          </div>
        </b-card-body>
      </b-collapse>
    </b-card>
    <button type="button" class="btn btn-primary">Cadastrar</button>
  </div>
</template>
<script>
export default {
  async created() {
    this.getUsuarios();
    this.getCargos();
    this.getCursos();
    this.getProfissoes();
  },
  methods: {
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
    async getCursos() {
      this.chamaApi("get", "/app/curso/get", []).then((response) => {
        this.optionsCurso = response.data;
      });
    },
    async getProfissoes() {
      this.chamaApi("get", "/app/tipo-usuario/get", []).then((response) => {
        this.optionsTipoUsuario = response.data;
      });
    },
  },
  data: function () {
    return {
      optionsTipoUsuario: null,
      optionsCargo: null,
      optionsCurso: null,
      optionsUsuario: null,
      data: {
        id: null,
        usuario: {
          curso: null,
          email: "",
          senha: "",
          confSenha: "",
          cargo: null,
          dadosUsuario: {
            nome: "",
            CPF: "",
            empresa: "",
            tipoUsuario: null,
          },
        },
        endereco: {
          logradouro: "",
          numero: "",
          UF: "",
          CEP: "",
          cidade: "",
          complemento: "",
        },
        contato: { telefone: "", celular: "" },
      },
    };
  },
};
</script>