<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FeroStreetWear</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/css2.css">
    

    <style>
                
    </style>
    
</head>
<body>
     <!-- Navbar -->
     <?php include 'includes/navbar.php';  ?>
     
    <div class="container my-5">
      <div class="row">
        <!-- Imagem do Produto -->
        <div class="col-md-6">
          <img id="product-image" src="" alt="Produto" class="img-fluid">
        </div>

        <!-- Detalhes do Produto -->
        <div class="col-md-6">
          <h2 id="product-name" class="fw-bold"></h2>
          <p id="product-price" class="text-muted fs-5"></p>

          <div class="mb-3">
            <h6>Tamanho:</h6>
            <div id="product-sizes" class="btn-group" role="group"></div>
          </div>

          <div class="mb-4">
            <h6>Descrição</h6>
            <p id="product-description"></p>
          </div>

          <button class="btn btn-dark w-100">Adicionar ao Carrinho</button>
        </div>
      </div>
    </div>

    <?php include 'includes/footer.php';  ?>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
      async function loadProductDetails() {
        // Captura o ID do produto da URL
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get("id");

        try {
          const response = await fetch("produtos.json");
          if (!response.ok) {
            throw new Error(`Erro ao buscar o arquivo JSON: ${response.status}`);
          }
          const produtos = await response.json();

          // Encontra o produto pelo ID
          const produto = produtos.find(p => p.id === parseInt(productId));
          if (!produto) {
            throw new Error("Produto não encontrado!");
          }

          // Preenche a página com os detalhes do produto
          document.getElementById("product-image").src = produto.foto;
          document.getElementById("product-image").alt = produto.nome;
          document.getElementById("product-name").textContent = produto.nome;
          document.getElementById("product-price").textContent = `€${produto.preço}`;
          document.getElementById("product-description").textContent = produto.descrição;

          // Preencher tamanhos
          const sizesContainer = document.getElementById("product-sizes");
          produto.tamanho.forEach(tamanho => {
            const sizeButton = document.createElement("button");
            sizeButton.className = "btn btn-outline-dark";
            sizeButton.textContent = tamanho;
            sizesContainer.appendChild(sizeButton);
          });
        } catch (error) {
          console.error("Erro ao carregar os detalhes do produto:", error);
        }
      }

      // Carrega os detalhes do produto ao iniciar a página
      document.addEventListener("DOMContentLoaded", loadProductDetails);
    </script>
    <?php
    // script barra pesquisa
    include 'scripts/scriptbarrapesquisa.php'; 
    ?>

  </body>
</html>
