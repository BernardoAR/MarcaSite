<template>
  <div>
    <navbar></navbar>
    <main class="py-4">
      <router-view></router-view>
    </main>
    <footer-comp></footer-comp>
  </div>
</template>
<script>
import Navbar from "../components/Navbar.vue";
import FooterComp from "../components/FooterComp.vue";
export default {
  props: ["usuario"],
  components: { Navbar, FooterComp },
  created() {
    this.$store.commit("atualizaUsuario", this.usuario);
  },
};
</script>