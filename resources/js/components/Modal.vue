<template>
  <div>
    <b-modal
      id="modal"
      :title="titulo"
      :ok-title="ok"
      :cancel-title="cancelar"
      cancel-variant="outline-secondary"
      ok-variant="outline-primary"
      class="text-white"
      @ok="$emit('click-ok')"
    >
      <p class="my-4">{{ texto }}</p>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: ["ok", "cancelar", "titulo", "texto"],
};
</script>