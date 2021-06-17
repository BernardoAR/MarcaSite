<template>
  <div class="container">
    <div class="card card-register mx-auto mt-5 col-sm-5">
      <div class="card-header">Cadastro</div>
      <div class="card-body">
        <div class="form-group">
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
            <label for="email">Email</label>
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
                <label for="password">Senha</label>
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
                  v-model="confSenha.valor"
                  autocomplete="new-password"
                  placeholder="Confirmar Senha"
                />
                <label for="password_conf">Confirmar Senha</label>
              </div>
            </div>
          </div>
        </div>
        <button
          type="submit"
          class="btn btn-primary btn-block"
          @click="cadastro"
        >
          Cadastrar
        </button>
        <div class="text-center">
          <router-link class="d-block mt-3" :to="{ name: 'login' }"
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
        email: "",
        senha: "",
      },
      confSenha: { valor: "" },
    };
  },
  methods: {
    async cadastro() {
      if (this.data.email.trim() == "")
        return this.erro("E-mail é obrigatório");
      if (this.data.senha.trim() == "") return this.erro("Senha é obrigatório");
      if (this.data.senha.length < 8)
        return this.erro("Senha precisa de 8 dígitos");
      if (this.confSenha.valor != this.data.senha)
        return this.erro('Campo "Senha" e "Confirmar Senha" não coincidem');

      const res = await this.chamaApi("post", "api/usuario/store", this.data);
      if (res.status === 200 || res.status === 201) {
        this.sucesso("Usuário cadastrado com sucesso!");
        this.$router.push({ name: "login" });
      } else {
        if (res.status == 422) {
          for (let i in res.data.errors) {
            this.e(res.data.errors[i][0]);
          }
        } else {
          this.swr();
        }
      }
    },
  },
};
</script>