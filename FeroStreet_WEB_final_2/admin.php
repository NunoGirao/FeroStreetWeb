<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu de Administração</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <style>
    
    .menu-box {
        height: 200px;
        background: white;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border: 2px solid #333;
        border-radius: 10px;
        margin-bottom: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .menu-box:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        
    }

    .menu-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    body {
        background: #f8f9fa;
    }

    .container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-voltar {
        background: black;
        color: white;
        padding: 10px 15px;
        margin-top: 20px;
        
    }

    .btn-voltar:hover {
        background:rgb(117, 117, 117);
    }
</style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Painel de Administração</h1>
        <div class="menu-container">
            <!-- Gestão de Stock -->
            <div class="menu-box" onclick="window.location.href='gestStock.php'">
                <h3>Gestão de Stock</h3>
            </div>
            <!-- Gestão de Produtos em Destaque -->
            <div class="menu-box" onclick="window.location.href='gestProdDest.php'">
                <h3>Gestão de Produtos em Destaque</h3>
            </div>
            <!-- Gestão de Afiliados -->
            <div class="menu-box" onclick="window.location.href='gestAfil.php'">
                <h3>Gestão de Afiliados</h3>
            </div>
            <!-- Gestão de Vendas -->
            <div class="menu-box" onclick="window.location.href='gestVendas.php'">
                <h3>Gestão de Vendas</h3>
            </div>
        </div>
        <!-- Botão de Voltar -->
        <button class="btn-voltar" onclick="window.location.href='index.php'">Voltar à Loja</button>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
