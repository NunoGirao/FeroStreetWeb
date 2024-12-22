<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FeroStreetWear</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/css2.css">
    <link rel="stylesheet" href="css/navbarcss.css">
    <style>
        
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php include 'includes/navbar.php';  ?>

    <!-- Container para os produtos -->
    <div class="container my-5">
        <div id="product-list" class="row g-4">
            
        </div>
    </div>
</body>

<!-- Footer -->
<?php include 'includes/footer.php';  ?>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
    async function loadProdutos() {
      try {
        const response = await fetch("produtos.json");
        if (!response.ok) {
          throw new Error(`Erro ao buscar o arquivo JSON: ${response.status}`);
        }
        const produtos = await response.json();
  
        // Filtrando os produtos que são apenas camisas
        const camisas = produtos.filter((produto) => produto.tipo === "Sweat");
  
        renderProdutos(camisas);
      } catch (error) {
        console.error("Erro ao carregar os produtos:", error);
      }
    }
  
    // Função para renderizar os produtos na página
    function renderProdutos(produtos) {
      const productContainer = document.getElementById("product-list");
      productContainer.innerHTML = ""; // Limpa o container antes de adicionar os produtos
  
      produtos.forEach((produto) => {
        const productCard = document.createElement("div");
        productCard.classList.add("col-lg-4", "col-md-6", "col-sm-12");
  
        // Adiciona o evento de clique para redirecionar à página de detalhes do produto com o ID no URL
        productCard.innerHTML = `
          <div class="card product-card h-100" onclick="window.location.href='pagprod.php?id=${produto.id}'">
            <img src="${produto.foto}" class="card-img-top" alt="${produto.nome}">
            <div class="card-body text-center">
              <h5 class="card-title">${produto.nome}</h5>
              <p class="card-text fw-bold">€${produto.preço}</p>
            </div>
          </div>
        `;
        productContainer.appendChild(productCard);
      });
    }
  
    // Carrega os produtos ao iniciar a página
    document.addEventListener("DOMContentLoaded", loadProdutos);
  </script>
  <?php
    // script barra pesquisa
    include 'scripts/scriptbarrapesquisa.php'; 
    ?>


</html>
