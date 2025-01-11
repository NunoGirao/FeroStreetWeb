<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Carrinho de Compras</title>

  <!-- Importa as folhas de estilo necessárias -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="css/css2.css" />
  <link rel="stylesheet" href="css/navbarcss.css" />
  <style>
    /* Estilos específicos para itens do carrinho */
    .cart-item {
      border-bottom: 1px solid #ccc;
      padding: 1rem 0;
    }
    .cart-total {
      font-size: 1.5rem;
      font-weight: bold;
      text-align: right;
    }
    .empty-cart {
      text-align: center;
      font-size: 1.25rem;
      color: gray;
      margin-top: 50px;
    }
    img.img-thumbnail {
      width: 100px;
      height: 100px;
      object-fit: cover;
    }
  </style>
</head>
<body>

  <!-- Inclui o menu de navegação -->
  <?php include 'includes/navbar.php'; ?>

  <div class="container my-5">
    <h2 class="mb-4">Carrinho de Compras</h2>
    <div id="cart-items" class="row g-4"></div> <!-- Contém os itens do carrinho -->
    <div class="cart-total mt-4 d-flex justify-content-between align-items-center">
      <span>Total: €<span id="cart-total">0.00</span></span>
      <button id="finalize-order" class="btn btn-success">Finalizar Compra</button>
    </div>
  </div>

  <!-- Inclui o rodapé -->
  <?php include 'includes/footer.php'; ?>

  <!-- Scripts necessários -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
    let cartData = [];

    // Renderiza os itens do carrinho dinamicamente
    function renderCartItems(cart) {
      const cartContainer = document.getElementById("cart-items");
      const cartTotalElement = document.getElementById("cart-total");

      if (cart.length === 0) {
        cartContainer.innerHTML = '<div class="empty-cart">O seu carrinho está vazio!</div>';
        cartTotalElement.textContent = "0.00";
        return;
      }

      cartContainer.innerHTML = "";
      let total = 0;

      cart.forEach((item) => {
        total += item.preco * item.quantidade; // Calcula o total com base na quantidade e preço

        const cartItem = document.createElement("div");
        cartItem.classList.add("col-12", "cart-item");

        cartItem.innerHTML = `
          <div class="d-flex align-items-center">
            <img src="${item.foto}" alt="${item.nome}" class="img-thumbnail me-3">
            <div>
              <h5>${item.nome}</h5>
              <p>Preço: €${item.preco.toFixed(2)} | Quantidade: ${item.quantidade}</p>
              <p>Tamanho: ${item.tamanho || "Não especificado"}</p>
              <div class="d-flex align-items-center">
                <!-- Botões para atualizar quantidade -->
                <button class="btn btn-sm btn-secondary update-quantity me-2" data-id="${item.id}" data-action="decrement">-</button>
                <span>${item.quantidade}</span>
                <button class="btn btn-sm btn-secondary update-quantity ms-2" data-id="${item.id}" data-action="increment">+</button>
              </div>
            </div>
            <button class="btn btn-danger btn-sm ms-auto remove-btn" data-id="${item.id}">Remover</button>
          </div>
        `;

        cartContainer.appendChild(cartItem);
      });

      cartTotalElement.textContent = total.toFixed(2); // Atualiza o total no HTML

      // Adicionar eventos para atualizar quantidade e remover itens
      document.querySelectorAll(".update-quantity").forEach((button) => {
        button.addEventListener("click", () => {
          const itemId = parseInt(button.getAttribute("data-id"), 10);
          const action = button.getAttribute("data-action");
          updateItemQuantity(itemId, action);
        });
      });

      document.querySelectorAll(".remove-btn").forEach((button) => {
        button.addEventListener("click", () => {
          const itemId = parseInt(button.getAttribute("data-id"), 10);
          removeItem(itemId);
        });
      });
    }

    // Atualiza a quantidade de itens no carrinho
    function updateItemQuantity(itemId, action) {
      const item = cartData.find((item) => item.id === itemId);
      if (item) {
        if (action === "increment") item.quantidade++;
        if (action === "decrement" && item.quantidade > 1) item.quantidade--;
        // Atualizar o localStorage após alterar a quantidade
        localStorage.setItem("cartData", JSON.stringify(cartData));
        renderCartItems(cartData);
      }
    }

    // Remove um item do carrinho
    function removeItem(itemId) {
      cartData = cartData.filter((item) => item.id !== itemId);
      // Atualizar o localStorage após remover o item
      localStorage.setItem("cartData", JSON.stringify(cartData));
      renderCartItems(cartData);
    }

    // Finaliza o pedido
    document.getElementById("finalize-order").addEventListener("click", () => {
      if (cartData.length === 0) {
        alert("O carrinho está vazio. Adicione itens antes de finalizar a compra.");
        return;
      }
      localStorage.setItem("cartData", JSON.stringify(cartData));
      window.location.href = "finalizar-compra.php"; // Redireciona para a página de finalização
    });

    // Carrega os dados do carrinho ao carregar a página
    document.addEventListener("DOMContentLoaded", () => {
      const storedCart = localStorage.getItem("cartData");
      cartData = storedCart ? JSON.parse(storedCart) : [];
      renderCartItems(cartData);
    });
  </script>
  <script src="scripts/scriptbarrapesquisa.js"></script>
</body>
</html>
