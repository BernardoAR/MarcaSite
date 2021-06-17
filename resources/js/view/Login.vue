<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right"
                >E-mail</label
              >
              <div class="col-md-6">
                <div class="space">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    name="email"
                    placeholder="E-mail"
                    autocomplete="email"
                    v-model="data.email"
                    required
                    autofocus
                  />
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right"
                >Senha</label
              >
              <div class="col-md-6">
                <div class="space">
                  <input
                    type="password"
                    class="form-control"
                    name="password"
                    placeholder="Senha"
                    v-model="data.senha"
                    required
                    autocomplete="current-password"
                  />
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6 offset-md-4">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    v-model="data.lembrar"
                  />

                  <label class="form-check-label" for="remember">
                    Lembrar-me
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button
                  type="submit"
                  class="btn btn-primary"
                  @click="login"
                  :disabled="estaLogando"
                  :loading="estaLogando"
                >
                  {{ estaLogando ? "Logando..." : "Login" }}
                </button>

                <a class="btn btn-link" href="ESQUECEUASENHA">
                  Esqueceu a Senha?
                </a>
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
        lembrar: false,
      },
      estaLogando: false,
    };
  },
  methods: {
    async login() {
      if (this.data.email.trim() == "")
        return this.erro("E-mail é obrigatório");
      if (this.data.senha.trim() == "") return this.erro("Senha é obrigatório");
      if (this.data.senha.length < 8)
        return this.erro("Senha precisa de 8 dígitos");
      this.estaLogando = true;
      const res = await this.chamaApi("post", "api/usuario/login", this.data);
      if (res.status === 200) {
        this.info(res.data.msg);
      } else {
        if (res.status === 401) {
          this.erro(res.data.msg);
        } else if (res.status === 422) {
          for (let i in res.data.errors) {
            this.erro(res.data.errors[i][0]);
          }
        } else {
          this.swr();
        }
      }
      this.estaLogando = false;
    },
  },
};
</script>