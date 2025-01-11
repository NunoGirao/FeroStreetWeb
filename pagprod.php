<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FeroStreetWear</title>

  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="css/css2.css" />
  <link rel="stylesheet" href="css/navbarcss.css" />
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <div class="container my-5">
    <div class="row">
      <!-- Imagem do Produto -->
      <div class="col-md-6">
        <img id="product-image" src="" alt="Produto" class="img-fluid" />
      </div>

      <!-- Detalhes do Produto -->
      <div class="col-md-6">
        <h2 id="product-name" class="fw-bold"></h2>
        <p id="product-price" class="text-muted fs-5"></p>

        <div class="mb-3">
          <h6>Tamanho:</h6>
          <div id="product-sizes" class="btn-group" role="group"></div>
          <p id="selected-size" class="text-muted mt-2">Tamanho selecionado: Nenhum</p>
        </div>

        <div class="mb-4">
          <h6>Descrição</h6>
          <p id="product-description"></p>
        </div>

        <button id="add-to-cart-btn" class="btn btn-dark w-100" disabled>Adicionar ao Carrinho</button>
      </div>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
    let selectedSize = null; // Variável para armazenar o tamanho selecionado

    // Carrega os detalhes do produto
    async function loadProductDetails() {
      const urlParams = new URLSearchParams(window.location.search);
      const productId = urlParams.get("id");

      try {
        const response = await fetch("produtos.json");
        if (!response.ok) {
          throw new Error(`Erro ao buscar o arquivo JSON: ${response.status}`);
        }

        const produtos = await response.json();
        const produto = produtos.find((p) => p.id === parseInt(productId));
        if (!produto) {
          throw new Error("Produto não encontrado!");
        }

        document.getElementById("product-image").src = produto.foto;
        document.getElementById("product-image").alt = produto.nome;
        document.getElementById("product-name").textContent = produto.nome;
        document.getElementById("product-price").textContent = `€${produto.preço}`;
        document.getElementById("product-description").textContent = produto.descrição;

        const sizesContainer = document.getElementById("product-sizes");
        produto.tamanho.forEach((tamanho) => {
          const sizeButton = document.createElement("button");
          sizeButton.className = "btn btn-outline-dark";
          sizeButton.textContent = tamanho;

          sizeButton.addEventListener("click", () => selectSize(tamanho, sizeButton));
          sizesContainer.appendChild(sizeButton);
        });
      } catch (error) {
        console.error("Erro ao carregar os detalhes do produto:", error);
      }
    }

    // Seleciona um tamanho
    function selectSize(size, button) {
      selectedSize = size;

      // Atualiza a interface para mostrar o tamanho selecionado
      document.querySelectorAll("#product-sizes button").forEach((btn) => {
        btn.classList.remove("active");
      });
      button.classList.add("active");

      document.getElementById("selected-size").textContent = `Tamanho selecionado: ${size}`;

      // Habilita o botão "Adicionar ao Carrinho"
      document.getElementById("add-to-cart-btn").disabled = false;
    }

    // Adiciona o produto ao carrinho
    function addToCart() {
      if (!selectedSize) {
        alert("Por favor, selecione um tamanho antes de adicionar ao carrinho.");
        return;
      }

      const produto = {
        id: parseInt(new URLSearchParams(window.location.search).get("id")),
        nome: document.getElementById("product-name").textContent,
        preco: parseFloat(
          document.getElementById("product-price").textContent.replace("€", "")
        ),
        foto: document.getElementById("product-image").src,
        tamanho: selectedSize,
        quantidade: 1,
      };

      const cartData = JSON.parse(localStorage.getItem("cartData")) || [];
      const existingItemIndex = cartData.findIndex(
        (item) => item.id === produto.id && item.tamanho === selectedSize
      );

      if (existingItemIndex !== -1) {
        cartData[existingItemIndex].quantidade += 1;
      } else {
        cartData.push(produto);
      }

      localStorage.setItem("cartData", JSON.stringify(cartData));
      window.location.href = "carrinho.php";
    }

    document.addEventListener("DOMContentLoaded", () => {
      loadProductDetails();

      const addToCartButton = document.getElementById("add-to-cart-btn");
      addToCartButton.addEventListener("click", addToCart);
    });
  </script>
  <script src="scripts/scriptbarrapesquisa.js"></script>
</body>
</html>
