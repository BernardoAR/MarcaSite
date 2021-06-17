<template>
    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">Lista</h2>
            <add-item-form/>
        </div>
        <list-view :tipoContatos="tipoContatos"/>
    </div>
</template>

<script>
    import AddItemForm from "./AddItemForm"
    import ListView from "./ListView"
    export default {
       components:{AddItemForm, ListView},
       data: function () {
           return {
               tipoContatos: []
           }
       },
       methods:{
           getList(){
               axios.get('api/tipo-contatos').then(response => {this.tipoContatos = response.data}).catch(error => {console.log(error)});
           },
       },
        created(){
           this.getList();
       }
    }
</script>
<style scoped>
.todoListContainer{
    width: 350px;
    margin: auto;
}
.heading{
    background: #e6e6e6;
    padding: 10px
}

#title{
    text-align: center;
}
</style>
