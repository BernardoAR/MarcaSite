<template>

        <main class="py-4">
            @yield('content')
        </main>
</template>
<script>
export default {
  data: function(){
    return{
      estaLogado: false
    }
  },
  methods: {

  }
}
</script>