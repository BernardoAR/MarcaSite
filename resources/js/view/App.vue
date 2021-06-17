<template>
  <div>
    <div v-if="$store.state.usuario">
      <navbar></navbar>
      <sidebar></sidebar>
      <div id="content-wrapper">
        <div class="container-fluid bg-white">
          <main class="py-4">
            <router-view></router-view>
          </main>
        </div>
        <footer-sistema></footer-sistema>
      </div>
    </div>
    <div v-else>
      <main class="py-4">
        <router-view></router-view>
      </main>
      <footer-comp></footer-comp>
    </div>
  </div>
</template>
<script>
import Navbar from "../components/Navbar.vue";
import FooterComp from "../components/FooterComp.vue";
import FooterSistema from "../components/FooterSistema.vue";
import Sidebar from "../components/Sidebar.vue";
export default {
  props: ["usuario"],
  components: { Navbar, FooterComp, FooterSistema, Sidebar },
  created() {
    this.$store.commit("atualizaUsuario", this.usuario);
  },
};
</script>