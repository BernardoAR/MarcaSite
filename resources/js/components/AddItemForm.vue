<template>
    <div class="addItem">
        <input type="text" v-model="tipoContato.titulo" />
        <button type="button" :class="[tipoContato.titulo? 'active': 'inactive']" @click="addItem()">+</button>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            tipoContato: {
                titulo: ""
            }
        };
    },
    methods: {
      addItem(){
        console.log('Aqui2');
        if(this.tipoContato.titulo == ''){
          return;
        }
        axios.post('api/tipo-contato/store', {tipoContato: this.tipoContato})
        .then(response => {
          if(response.status == 201){
          this.tipoContato.titulo == '';
        }})
        .catch(error => {
          console.log(error);
        })
      }
    }
};
</script>
<style scoped>
.addItem {
    display: flex;
    justify-content: center;
    align-items: center;
}
input {
    background: #f7f7f7;
    border: 0px;
    outline: none;
    padding: 5px;
    margin-right: 10px;
    width: 100%;
}
.active{
  color: #00CE25;
}
.inactive{
  color: #999999;
}
</style>
