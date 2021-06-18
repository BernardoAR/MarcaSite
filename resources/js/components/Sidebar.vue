<template>
  <div>
    <b-sidebar
      id="sidebar-1"
      title="Menu"
      bg-variant="dark"
      text-variant="light"
      z-index="6"
      shadow
    >
      <div class="px-3 py-2">
        <hr class="dropdown-divider" />
        <nav class="mb-3">
          <b-navbar toggleable type="dark" variant="dark">
            <b-navbar-brand href="#">Curso</b-navbar-brand>
            <b-navbar-toggle target="navbar-toggle-collapse-curso">
              <template #default="{ expanded }">
                <b-icon v-if="expanded" icon="chevron-bar-up"></b-icon>
                <b-icon v-else icon="chevron-bar-down"></b-icon>
              </template>
            </b-navbar-toggle>

            <b-collapse id="navbar-toggle-collapse-curso" is-nav>
              <b-navbar-nav class="ml-auto">
                <b-nav-item :to="{ name: 'cursoCad' }">Adicionar</b-nav-item>
                <b-nav-item :to="{ name: 'cursoList' }">Listar</b-nav-item>
              </b-navbar-nav>
            </b-collapse>
          </b-navbar>
          <b-navbar toggleable type="dark" variant="dark">
            <b-navbar-brand href="#">Usuário</b-navbar-brand>
            <b-navbar-toggle target="navbar-toggle-collapse-usuario">
              <template #default="{ expanded }">
                <b-icon v-if="expanded" icon="chevron-bar-up"></b-icon>
                <b-icon v-else icon="chevron-bar-down"></b-icon>
              </template>
            </b-navbar-toggle>

            <b-collapse id="navbar-toggle-collapse-usuario" is-nav>
              <b-navbar-nav class="ml-auto">
                <b-nav-item href="#">Adicionar</b-nav-item>
                <b-nav-item href="#">Listar</b-nav-item>
              </b-navbar-nav>
            </b-collapse>
          </b-navbar>
          <b-navbar toggleable type="dark" variant="dark">
            <b-navbar-brand href="#">Inscrição</b-navbar-brand>
            <b-navbar-toggle target="navbar-toggle-collapse-inscricao">
              <template #default="{ expanded }">
                <b-icon v-if="expanded" icon="chevron-bar-up"></b-icon>
                <b-icon v-else icon="chevron-bar-down"></b-icon>
              </template>
            </b-navbar-toggle>

            <b-collapse id="navbar-toggle-collapse-inscricao" is-nav>
              <b-navbar-nav class="ml-auto">
                <b-nav-item :to="{ name: 'inscricaoCad' }"
                  >Adicionar</b-nav-item
                >
                <b-nav-item href="#">Listar</b-nav-item>
              </b-navbar-nav>
            </b-collapse>
          </b-navbar>
        </nav>
      </div>
    </b-sidebar>
  </div>
</template>
<script>
export default {};
</script>