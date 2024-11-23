<!-- Navbar -->
<nav class="navbar bg-body-tertiary">
    <div class="container-fluid d-flex align-items-center position-relative">

        <!-- Botão de menu hambúrguer -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="logo-container position-absolute start-50 translate-middle-x d-flex align-items-center">
            <img src="imgs/fero_logo.png" alt="Logo da Marca" style="height: 70px; margin-right: 5px;">
            <a class="navbar-brand text-center mb-0" href="index.php">Fero Street Wear</a>
        </div>

        <!-- Barra de pesquisa e ícone de carrinho -->
        <div class="d-flex align-items-center ms-auto">
            <div class="search-bar position-relative">
                <i class="bi bi-search"></i>
                <input type="text" id="search-input" placeholder="Pesquise produtos..." oninput="performSearch()">
                <div id="search-results" style="display: none; background-color: #fff; border: 1px solid #ccc; max-width: 300px;"></div>
            </div>
            <!-- Carrinho de Compras -->
            <a href="carrinho.php" class="icon ms-3">
                <i class="bi bi-bag"></i>
            </a>
        </div>

        <!-- Menu colapsável -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-5 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="camisas.php">Camisas</a></li>
                <li class="nav-item"><a class="nav-link" href="tshirts.php">T-Shirts</a></li>
                <li class="nav-item"><a class="nav-link" href="sweats.php">Sweats</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#sobre">Sobre</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Afiliados</a></li>
                <li class="nav-item"><a class="nav-link" href="contacto.php">Contactos</a></li>
            </ul>
        </div>
    </div>
</nav>
