<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="dark">
      <b-button v-b-toggle.sidebar-1 class="bg-dark"
        ><Icon type="ios-menu" />
      </b-button>
      <b-navbar-brand :to="{ path: '/home' }" class="ml-3"
        >MarcaSite</b-navbar-brand
      >

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item href="#">Link</b-nav-item>
        </b-navbar-nav>

        <b-navbar-nav class="ml-auto">
          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template #button-content>
              <Icon type="md-cog" />
            </template>
            <b-dropdown-item @click="deslogar">Sair</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>
<script>
export default {
  methods: {
    deslogar() {
      window.location.href = "/deslogar";
    },
  },
  data: function () {
    return { estaLogado: false };
  },
};
</script>