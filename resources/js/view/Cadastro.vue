<template>
  <div class="container">
    <div class="card card-register mx-auto mt-5 col-md-5">
      <div class="card-header">Cadastro</div>
      <div class="card-body">
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-label-group">
                <input
                  id="nome"
                  type="nome"
                  class="form-control"
                  name="nome"
                  v-model="data.nome"
                  required
                  autocomplete="nome"
                  placeholder="Nome"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-label-group">
                <input
                  id="email"
                  type="email"
                  class="form-control"
                  name="email"
                  v-model="data.email"
                  required
                  autocomplete="email"
                  placeholder="E-mail"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-label-group">
                <input
                  id="password"
                  type="password"
                  class="form-control"
                  name="password"
                  required
                  v-model="data.senha"
                  autocomplete="new-password"
                  placeholder="Senha"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-label-group">
                <input
                  id="password_conf"
                  type="password"
                  class="form-control"
                  name="password_confirmation"
                  required
                  v-model="data.confSenha"
                  autocomplete="new-password"
                  placeholder="Confirmar Senha"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <b-form-select v-model="data.cargo" :options="options">
            <template #first>
              <b-form-select-option :value="null" disabled
                >-- Selecione --</b-form-select-option
              >
            </template>
          </b-form-select>
        </div>
        <b-button
          @click="cadastro"
          :disabled="estaCadastrando"
          :loading="estaCadastrando"
          variant="outline-primary"
        >
          {{ estaCadastrando ? "Cadastrando..." : "Cadastrar" }}
        </b-button>
        <div class="text-center">
          <router-link class="d-block mt-3" :to="{ path: 'login' }"
            >Voltar</router-link
          >
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      data: {
        nome: "",
        email: "",
        senha: "",
        cargo: null,
        confSenha: "",
      },
      estaCadastrando: false,
      options: null,
    };
  },
  async created() {
    this.chamaApi("get", "/api/cargo-usuario", []).then((response) => {
      this.options = response.data;
    });
  },
  methods: {
    validaCadastro() {
      let erros = [];
      // Valida a parte do usuarioForm
      erros = this.validacao(this.data, {
        nome: "required",
        email: "required|email",
        senha: "required|minLength:8|match:confSenha",
        cargo: "required",
      });
      erros.map((valor) => {
        this.$store.state.possuiErroForm = true;
        this.erro(valor);
      });
    },
    async cadastro() {
      this.validaCadastro();
      if (!this.$store.state.possuiErroForm) {
        this.estaCadastrando = true;
        const res = await this.chamaApi("post", "api/usuario/store", this.data);
        if (res.status === 200 || res.status === 201) {
          this.sucesso("Usuário cadastrado com sucesso!");
          this.$router.push({ path: "login" });
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
      }
      this.estaCadastrando = false;
    },
  },
};
</script>