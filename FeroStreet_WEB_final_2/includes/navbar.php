<nav class="navbar bg-body-tertiary">
    <div class="container-fluid d-flex flex-column align-items-center position-relative">

        <!-- Logo e nome centralizados -->
        <div class="logo-container text-center">
            <img src="imgs/fero_logo.png" alt="Logo da Marca" style="height: 70px;">
            <a class="navbar-brand d-block" href="index.php">Fero Street Wear</a>
        </div>

        <!-- Botão hambúrguer para telas pequenas -->
        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links do menu -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav flex-column flex-md-row justify-content-center">
                <li class="nav-item"><a class="nav-link" href="camisas.php">Camisas</a></li>
                <li class="nav-item"><a class="nav-link" href="tshirts.php">T-Shirts</a></li>
                <li class="nav-item"><a class="nav-link" href="sweats.php">Sweats</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#sobre">Sobre</a></li>
                <li class="nav-item"><a class="nav-link" href="progafiliados.php">Afiliados</a></li>
                <li class="nav-item"><a class="nav-link" href="contacto.php">Contactos</a></li>
            </ul>
        </div>

        <!-- Área de ícones (Pesquisa, Carrinho, Admin) -->
        <div class="d-flex justify-content-end align-items-center w-100 position-absolute" style="top: 0; right: 0;">
            <div class="search-bar" style="position: relative;">
                <i class="bi bi-search"></i> 
                <input type="text" id="search-input" placeholder="Pesquise produtos..." oninput="performSearch()">
                <div id="search-results"></div> 
            </div>
            <a href="#" class="icon" id="admin-icon" title="Administração"><i class="bi bi-gear"></i></a>
            <a href="carrinho.php" class="icon"><i class="bi bi-bag"></i></a> 
        </div>
    </div>
</nav>

<!-- Modal para inserção do PIN -->
<div id="pin-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 20px; border-radius: 10px; text-align: center; width: 300px;">
        <h5>Insira o PIN de administrador</h5>
        <input type="password" id="admin-pin" placeholder="Digite o PIN" style="margin-bottom: 10px; width: 100%; padding: 5px;">
        <div>
            <button id="submit-pin" style="margin-right: 10px;">Entrar</button>
            <button id="cancel-pin">Cancelar</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const adminIcon = document.getElementById('admin-icon');
        const pinModal = document.getElementById('pin-modal');
        const submitPinButton = document.getElementById('submit-pin');
        const cancelPinButton = document.getElementById('cancel-pin');
        const adminPinInput = document.getElementById('admin-pin');
        const correctPin = "3546"; // PIN 

        // Abrir modal Pin
        adminIcon.addEventListener('click', function (event) {
            event.preventDefault(); 
            pinModal.style.display = 'flex';
        });

        // Verificar PIN e redirecionar
        submitPinButton.addEventListener('click', function () {
            const enteredPin = adminPinInput.value;
            if (enteredPin === correctPin) {
                window.location.href = 'admin.php'; 
            } else {
                alert('PIN incorreto. Tente novamente.');
            }
        });

        // Fechar modal de Pin
        cancelPinButton.addEventListener('click', function () {
            pinModal.style.display = 'none'; 
            adminPinInput.value = ''; 
        });
    });
</script>
