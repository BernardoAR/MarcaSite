<template>
  <div>
    <usuario></usuario>
    <b-button @click="pegaDados">BOTAOZITCHO</b-button>
  </div>
</template>
<script>
import Usuario from "../../../components/App/Usuario.vue";

export default {
  methods: {
    pegaDados() {
      console.log(this.$store.state.usuarioForm);
    },
  },
  components: { Usuario },
  data() {
    return {};
  },
};
</script>