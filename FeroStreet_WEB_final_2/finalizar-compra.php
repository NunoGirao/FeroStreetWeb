<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Finalizar Compra</title>
  <!-- Incluímos o Bootstrap para estilos básicos e responsividade -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    /* Estilo geral da página */
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }

    /* Estilo para o logotipo */
    .logo {
      text-align: center;
      margin: 30px 0;
    }

    /* Container principal do formulário e resumo do pedido */
    .form-container {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Estilo para o formulário de finalização */
    .checkout-form {
      flex: 2;
    }

    /* Estilo para o resumo do pedido */
    .order-summary {
      flex: 1;
      background-color: #e0f6f5;
      padding: 20px;
      border-radius: 8px;
    }

    /* Estilo das imagens dos produtos */
    .order-summary img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 4px;
    }

    /* Estilo para o total */
    .total {
      font-weight: bold;
      font-size: 1.2rem;
    }

    /* Estilo para a caixa de desconto */
    .discount-box {
      margin-top: 20px;
    }

    .discount-box .input-group {
      display: flex;
      align-items: center;
    }
  </style>
</head>

<body>
  <!-- Logotipo da empresa -->
  <div class="logo">
    <a href="index.php">
      <img src="imgs/fero_logo.png" alt="Logo" width="100">
    </a>
  </div>

  <!-- Container para o formulário e resumo do pedido -->
  <div class="form-container">
    <!-- Formulário de Finalização -->
    <div class="checkout-form">
      <h4>Contacto</h4>
      <form id="checkout-form">
        <!-- Campo para o e-mail -->
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" placeholder="Introduza o seu e-mail" required>
        </div>
        <h4 class="mt-4">Entrega</h4>
        <!-- Campos para o nome e sobrenome -->
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="first-name" class="form-label">Nome próprio</label>
            <input type="text" class="form-control" id="first-name" placeholder="Nome" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="last-name" class="form-label">Sobrenome</label>
            <input type="text" class="form-control" id="last-name" placeholder="Sobrenome" required>
          </div>
        </div>
        <!-- Campo para o endereço -->
        <div class="mb-3">
          <label for="address" class="form-label">Endereço</label>
          <input type="text" class="form-control" id="address" placeholder="Rua, número, etc." required>
        </div>
        <!-- Campos para o código postal e cidade -->
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="postal-code" class="form-label">Código postal</label>
            <input type="text" class="form-control" id="postal-code" placeholder="0000-000" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="city" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="city" placeholder="Cidade" required>
          </div>
        </div>
        <!-- Campo para o número de telemóvel -->
        <div class="mb-3">
          <label for="phone" class="form-label">Telemóvel</label>
          <input type="tel" class="form-control" id="phone" placeholder="Número de telemóvel" required>
        </div>
        <!-- Botão para confirmar a compra -->
        <button type="submit" class="btn btn-primary w-100 mt-3">Confirmar Compra</button>
      </form>
    </div>

    <!-- Resumo do Pedido -->
    <div class="order-summary">
      <h5>Resumo do Pedido</h5>
      <!-- Lista de itens do carrinho -->
      <div id="cart-items"></div>
      <hr>
      <!-- Campo para aplicar o código de desconto -->
      <div class="discount-box">
        <div class="input-group">
          <input type="text" id="discount-code" class="form-control" placeholder="Código de desconto">
          <button id="apply-discount" class="btn btn-success">Aplicar</button>
        </div>
        <div id="discount-message" style="color: red; margin-top: 10px;"></div>
      </div>
      <!-- Mensagem de desconto aplicado -->
      <div class="discount-applied" id="discount-applied" style="display: none;">
        Desconto aplicado: -€<span id="discount-amount">0.00</span>
      </div>
      <hr>
      <!-- Total do carrinho -->
      <div class="d-flex justify-content-between total">
        <span>Total</span>
        <span>€<span id="cart-total">0.00</span></span>
      </div>
      <!-- Botão para imprimir o recibo -->
      <button id="print-receipt" class="btn btn-info w-100 mt-3" style="display: none;">Imprimir Recibo</button>
    </div>
  </div>

  <!-- Incluímos a biblioteca jsPDF para gerar PDFs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script>
    /* Arquivo JSON com os códigos de desconto */
    const discountFile = 'dados_afiliados.json';

    /* Dados do carrinho armazenados no localStorage */
    const cartData = JSON.parse(localStorage.getItem("cartData")) || [{
      id: 1,
      nome: "Produto Exemplo",
      preco: 20.00,
      tamanho: "M",
      foto: "https://via.placeholder.com/150",
      quantidade: 2
    }];

    /* Variáveis para descontos */
    let discountPercentage = 0;
    let totalWithoutDiscount = 0;

    /* Renderiza os itens do carrinho no resumo do pedido */
    function renderOrderSummary() {
      const cartItemsContainer = document.getElementById("cart-items");
      const cartTotalElement = document.getElementById("cart-total");
      totalWithoutDiscount = 0;

      cartItemsContainer.innerHTML = "";

      cartData.forEach(item => {
        totalWithoutDiscount += item.preco * item.quantidade;

        const cartItem = document.createElement("div");
        cartItem.classList.add("d-flex", "align-items-center", "mb-3");

        cartItem.innerHTML = `
        <img src="${item.foto}" alt="${item.nome}" class="me-3">
        <div>
          <div>${item.nome}</div>
          <div class="text-muted" style="font-size: 0.9rem;">${item.tamanho} | Qtde: ${item.quantidade}</div>
        </div>
        <div class="ms-auto">€${(item.preco * item.quantidade).toFixed(2)}</div>
      `;

        cartItemsContainer.appendChild(cartItem);
      });

      applyDiscount();
    }

    /* Aplica o desconto ao carrinho */
    async function applyDiscount() {
      const discountCode = document.getElementById("discount-code").value.trim();
      const discountMessage = document.getElementById("discount-message");
      const discountAppliedElement = document.getElementById("discount-applied");
      const discountAmountElement = document.getElementById("discount-amount");
      const cartTotalElement = document.getElementById("cart-total");

      if (!discountCode) {
        discountPercentage = 0;
        discountMessage.textContent = '';
        discountAppliedElement.style.display = 'none';
        cartTotalElement.textContent = totalWithoutDiscount.toFixed(2);
        return;
      }

      try {
        const response = await fetch(discountFile);
        const discountData = await response.json();

        const validDiscount = discountData.find(d => d.codigoDesconto === discountCode);

        if (validDiscount) {
          discountPercentage = validDiscount.percentagem || 10;
          discountMessage.textContent = 'Código de desconto aplicado com sucesso!';
          discountMessage.style.color = 'green';

          const discountAmount = totalWithoutDiscount * (discountPercentage / 100);
          const totalWithDiscount = totalWithoutDiscount - discountAmount;

          discountAppliedElement.style.display = 'block';
          discountAmountElement.textContent = discountAmount.toFixed(2);
          cartTotalElement.textContent = totalWithDiscount.toFixed(2);
        } else {
          discountPercentage = 0;
          discountMessage.textContent = 'Código de desconto inválido.';
          discountMessage.style.color = 'red';
          discountAppliedElement.style.display = 'none';
          cartTotalElement.textContent = totalWithoutDiscount.toFixed(2);
        }
      } catch (error) {
        console.error("Erro ao carregar o arquivo JSON:", error);
        discountMessage.textContent = 'Erro ao validar o código de desconto.';
        discountMessage.style.color = 'red';
        discountAppliedElement.style.display = 'none';
      }
    }

    /* Submete o pedido */
    async function submitOrder(event) {
      event.preventDefault();

      const formData = {
        firstName: document.getElementById("first-name").value,
        lastName: document.getElementById("last-name").value,
        email: document.getElementById("email").value,
        address: document.getElementById("address").value,
        city: document.getElementById("city").value,
        postalCode: document.getElementById("postal-code").value,
        phone: document.getElementById("phone").value,
        cartData,
        total: document.getElementById("cart-total").textContent
      };

      try {
        const response = await fetch("guardar_encomenda.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(formData)
        });

        if (response.ok) {
          const result = await response.json();
          if (result.success) {
            alert("Compra finalizada com sucesso!");
            document.getElementById("print-receipt").style.display = 'block';
            localStorage.removeItem("cartData");
          } else {
            alert("Erro ao salvar a encomenda: " + result.message);
          }
        } else {
          alert("Erro ao processar a compra. Tente novamente.");
        }
      } catch (error) {
        console.error("Erro ao finalizar a compra:", error);
        alert("Ocorreu um erro ao processar seu pedido.");
      }
    }

    /* Gera e imprime o recibo */
    function printReceipt() {
      const {
        jsPDF
      } = window.jspdf;
      const doc = new jsPDF();

      doc.text("Recibo de Compra", 105, 20, {
        align: "center"
      });
      doc.text(`Nome: ${document.getElementById("first-name").value} ${document.getElementById("last-name").value}`, 10, 40);
      doc.text(`E-mail: ${document.getElementById("email").value}`, 10, 50);
      doc.text(`Endereço: ${document.getElementById("address").value}`, 10, 60);
      doc.text(`Cidade: ${document.getElementById("city").value}`, 10, 70);
      doc.text(`Código Postal: ${document.getElementById("postal-code").value}`, 10, 80);
      doc.text(`Telemóvel: ${document.getElementById("phone").value}`, 10, 90);

      doc.text("Itens do Carrinho:", 10, 110);
      cartData.forEach((item, index) => {
        doc.text(`${item.nome} (${item.tamanho}) x${item.quantidade} - €${(item.preco * item.quantidade).toFixed(2)}`, 10, 120 + (index * 10));
      });

      doc.text(`Total: €${document.getElementById("cart-total").textContent}`, 10, 130 + (cartData.length * 10));

      if (discountPercentage > 0) {
        doc.text(`Desconto: -€${document.getElementById("discount-amount").textContent}`, 10, 140 + (cartData.length * 10));
      }

      doc.save("recibo_compra.pdf");
    }

    /* Evento para carregar dados ao iniciar */
    document.addEventListener("DOMContentLoaded", () => {
      renderOrderSummary();

      document.getElementById("apply-discount").addEventListener("click", applyDiscount);

      document.getElementById("checkout-form").addEventListener("submit", submitOrder);

      document.getElementById("print-receipt").addEventListener("click", () => {
        printReceipt();
        window.location.href = "index.php";
      });
    });
  </script>

</body>

</html>
