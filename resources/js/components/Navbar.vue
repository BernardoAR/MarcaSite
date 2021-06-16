<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/login">
                   MarcaSite
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="TOGGLE NAVIGATION">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Lado esquerdo da Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <!-- Lado direito da Navbar-->
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>

                        <li class="nav-item">
                            <a class="nav-link" href="/cadastro">Cadastrar</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/logout">Sair</a>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
</template>
<script>
export default {

}
</script>