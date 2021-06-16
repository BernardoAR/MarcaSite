<template>
  <div>
    <div v-for="(tipoContato, index) in tipoContatos" :key="index">
      <list-item :tipoContato="tipoContato" class="item"/>
    </div>
  </div>
</template>
<script>
import ListItem from './ListItem';
export default {
  props: ['tipoContatos'],
  components: {
    ListItem
  }
}
</script>
<style scoped>
.item{
  background: #e6e6e6;
  padding: 5px;
  margin-top: 5px;
}
</style>
