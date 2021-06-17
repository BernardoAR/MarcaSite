<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Cadastro</div>
          <div class="card-body">
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right"
                >E-mail</label
              >
              <div class="col-md-6">
                <input
                  id="email"
                  type="email"
                  class="form-control"
                  name="email"
                  v-model="data.email"
                  required
                  autocomplete="email"
                />
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Senha</label>

              <div class="col-md-6">
                <input
                  type="password"
                  class="form-control"
                  name="password"
                  required
                  v-model="data.senha"
                  autocomplete="new-password"
                />
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right"
                >Confirmar Senha</label
              >

              <div class="col-md-6">
                <input
                  type="password"
                  class="form-control"
                  name="password_confirmation"
                  required
                  v-model="confSenha.valor"
                  autocomplete="new-password"
                />
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary" @click="cadastro">
                  Registrar
                </button>
              </div>
            </div>
          </div>
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

      const res = await this.chamaApi("post", "api/usuario/login", this.data);
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