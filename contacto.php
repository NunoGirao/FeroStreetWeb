<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/css2.css">
</head>
<body>

<style>
     
</style>
    <!-- Navbar -->
    <?php include 'includes/navbar.php';  ?>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
            <h2 class="mb-3">Contacte-nos</h2>
            <p class="text-muted mb-4">Se precisar de ajuda, não hesite em contactar-nos. Vamos ajudar o mais rapidamente possível, normalmente o seu pedido será atendido dentro de 24h.</p>
            
            <form action="#" method="post">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="mensagem" class="form-label">Mensagem</label>
                    <textarea class="form-control" id="mensagem" name="mensagem" rows="4" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-dark w-100">Enviar</button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php';  ?>


    <script src="js/bootstrap.bundle.min.js"></script>
    <?php
    // script barra pesquisa
    include 'scripts/scriptbarrapesquisa.php'; 
    ?>

</body>

</html>