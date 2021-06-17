<template>
  <div class="item">
    <button><span>{{tipoContato.titulo}}</span></button>
    <button @click="removeItem()">X</button>
  </div>
</template>
<script>
export default {
  props: ['tipoContato']
}
</script>
<style scoped>
.itemText{
  width:100%;
  margin-left:20px;
}
.item{
  display:flex;
  justify-content:center;
  align-items: center;
}
.lixo{
  background: #e6e6e6;
  border: none;
  outline: none;
  color: #FF0000;
}
</style>
