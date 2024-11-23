<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Carrinho de Compras</title>


  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="css/css2.css" />
  <style>
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

  <?php include 'includes/navbar.php'; ?>


  <div class="container my-5">
    <h2 class="mb-4">Carrinho de Compras</h2>
    <div id="cart-items" class="row g-4"></div>
    <div class="cart-total mt-4">
      Total: €<span id="cart-total">0.00</span>
    </div>
  </div>


  <?php include 'includes/footer.php'; ?>


  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
 
    const cartData = [
      { id: 1, nome: "Camisa Dangerous", preco: 29.90, foto: "imgs/camisas/camisa1.jpg", quantidade: 2 },
      { id: 2, nome: "Camisa Strength", preco: 29.90, foto: "imgs/camisas/camisa2.jpg", quantidade: 1 },
      { id: 3, nome: "Sweat Leo-Navy", preco: 49.90, foto: "imgs/sweats/sweat1.jpg", quantidade: 1 }
    ];

 
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
        total += item.preco * item.quantidade;

        const cartItem = document.createElement("div");
        cartItem.classList.add("col-12", "cart-item");

        cartItem.innerHTML = `
          <div class="d-flex align-items-center">
            <img src="${item.foto}" alt="${item.nome || 'Produto sem nome'}" class="img-thumbnail me-3">
            <div>
              <h5>${item.nome}</h5>
              <p>Preço: €${item.preco.toFixed(2)} | Quantidade: ${item.quantidade}</p>
            </div>
            <button class="btn btn-danger btn-sm ms-auto remove-btn" data-id="${item.id}">Remover</button>
          </div>
        `;

        cartContainer.appendChild(cartItem);
      });

      cartTotalElement.textContent = total.toFixed(2);

   
      const removeButtons = document.querySelectorAll(".remove-btn");
      removeButtons.forEach((button) => {
        button.addEventListener("click", () => {
          const itemId = parseInt(button.getAttribute("data-id"), 10);
          removeItem(itemId);
        });
      });
    }

    
    function removeItem(itemId) {
      const index = cartData.findIndex((item) => item.id === itemId);
      if (index !== -1) {
        cartData.splice(index, 1);
        renderCartItems(cartData);
      } else {
        console.error("Produto não encontrado.");
      }
    }

   
    document.addEventListener("DOMContentLoaded", () => {
      renderCartItems(cartData);
    });
  </script>
</body>
</html>
