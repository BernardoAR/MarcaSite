<template>
  <div class="container">
    <div class="card card-login mx-auto mt-5 col-md-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <div class="form-group">
          <div class="form-label-group">
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
        <div class="form-group">
          <div class="form-label-group">
            <input
              id="password"
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
        <div class="form-group">
          <div class="form-label-group">
            <div class="form-check">
              <input
                id="remember"
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
        <b-button
          @click="login"
          :disabled="estaLogando"
          :loading="estaLogando"
          variant="outline-primary"
        >
          {{ estaLogando ? "Logando..." : "Login" }}
        </b-button>
        <div class="text-center">
          <router-link class="d-block mt-3" :to="{ path: '/cadastro' }"
            >Cadastre-se</router-link
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
      const res = await this.chamaApi("post", "/login/logar", this.data);
      if (res.status === 200) {
        this.info(res.data.msg);
        window.location.href = "/home";
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