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
            <b-form-select
              v-model="data.id"
              v-on:change="atualizaCampos"
              :options="optionsUsuario"
            >
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
                v-model="data.usuario.nome"
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
                v-model="data.usuario.dadosUsuario.empresa"
                type="text"
                class="form-control"
                id="empresa"
                name="empresa"
                placeholder="Empresa"
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
              <b-form-select v-model="data.curso" :options="optionsCurso">
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
          <div class="form-group row">
            <div class="form-label-group col-sm-6">
              <input
                v-model="data.usuario.dadosUsuario.cpf"
                type="number"
                class="form-control"
                id="cpf"
                name="cpf"
                placeholder="CPF"
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
            <div class="form-label-group col-sm-2">
              <input
                v-model="data.contato.telefone.ddd"
                type="number"
                class="form-control"
                id="telefoneDDD"
                name="telefoneDDD"
                placeholder="DDD"
                min="2"
                max="2"
              />
            </div>
            <div class="form-label-group col-sm-10">
              <input
                v-model="data.contato.telefone.numero"
                type="number"
                class="form-control"
                id="telefone"
                name="telefone"
                placeholder="Telefone"
                min="8"
                max="9"
                required
              />
            </div>
          </div>
          <div class="form-group row">
            <div class="form-label-group col-sm-2">
              <input
                v-model="data.contato.celular.ddd"
                type="number"
                class="form-control"
                id="celularDDD"
                name="celularDDD"
                placeholder="DDD"
                min="2"
                max="2"
              />
            </div>
            <div class="form-label-group col-sm-10">
              <input
                v-model="data.contato.celular.numero"
                type="number"
                class="form-control"
                id="telefone"
                name="telefone"
                placeholder="Celular"
                min="8"
                max="9"
                required
              />
            </div>
          </div>
        </b-card-body>
      </b-collapse>
    </b-card>
    <button
      type="submit"
      @click="cadastro"
      :disabled="estaCadastrando"
      :loading="estaCadastrando"
      class="btn btn-primary"
    >
      {{ estaCadastrando ? "Cadastrando..." : "Cadastrar" }}
    </button>
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
    atualizaCampos(id) {
      if (id != null) {
        this.chamaApi("get", `/app/dados-usuario/get/${id}`, []).then(
          (response) => {
            this.data = response.data;
          }
        );
      }
    },
    async cadastro() {
      if (this.data.usuario.nome.trim() == "")
        return this.erro("Nome é obrigatório!");
      if (this.data.usuario.email.trim() == "")
        return this.erro("E-mail é obrigatório");
      if (this.data.usuario.senha.trim() == "")
        return this.erro("Senha é obrigatório!");
      if (this.data.usuario.senha.length < 8)
        return this.erro("Senha precisa de 8 dígitos");
      if (this.confSenha != this.data.usuario.senha)
        return this.erro('Campo "Senha" e "Confirmar Senha" não coincidem!');
      if (this.data.usuario.cargo == null)
        return this.erro("Campo de cargo não pode ficar sem ser preenchido!");
      if (this.data.usuario.dadosUsuario.cpf.trim() == "")
        return this.erro("Campo de CPF não pode ficar sem ser preenchido!");
      if (this.data.usuario.dadosUsuario.tipoUsuario == null)
        return this.erro(
          "Campo de profissão não pode ficar sem ser preenchido!"
        );
      if (this.data.endereco.logradouro.trim() == "")
        return this.erro(
          "Campo de logradouro não pode ficar sem ser preenchido!"
        );
      if (this.data.curso == null)
        return this.erro("Campo de curso não pode ficar sem ser preenchido!");
      if (this.data.endereco.numero.trim() == "")
        return this.erro("Campo de numero não pode ficar sem ser preenchido!");
      if (this.data.endereco.uf.trim() == "")
        return this.erro("Campo de uf não pode ficar sem ser preenchido!");
      if (this.data.endereco.cep.trim() == "")
        return this.erro("Campo de CEP não pode ficar sem ser preenchido!");
      if (this.data.endereco.cidade.trim() == "")
        return this.erro("Campo de cidade não pode ficar sem ser preenchido!");
      this.estaCadastrando = true;
      const res = await this.chamaApi(
        "post",
        "/app/inscricao/store",
        this.data
      );
      if (res.status === 200 || res.status === 201) {
        this.sucesso("Inscrição realizada com sucesso!");
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
    },
  },
  data: function () {
    return {
      optionsTipoUsuario: null,
      optionsCargo: null,
      optionsCurso: null,
      optionsUsuario: null,
      confSenha: "",
      estaCadastrando: false,
      data: {
        id: null,
        curso: null,
        usuario: {
          email: "",
          senha: "",
          cargo: null,
          nome: "",
          dadosUsuario: {
            cpf: "",
            empresa: "",
            tipoUsuario: null,
          },
        },
        endereco: {
          id: "",
          logradouro: "",
          numero: "",
          uf: "",
          cep: "",
          cidade: "",
          complemento: "",
        },
        contato: {
          telefone: { ddd: "", numero: "" },
          celular: { ddd: "", numero: "" },
        },
      },
    };
  },
};
</script>