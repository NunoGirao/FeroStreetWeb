<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestão de Encomendas</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }

    .container {
      margin-top: 30px;
    }

    .logo {
      text-align: center;
      margin: 20px 0;
    }

    table {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    th,
    td {
      text-align: center;
      vertical-align: middle;
    }
  </style>
</head>

<body>
  <div class="logo">
    <a href="index.php">
      <img src="imgs/fero_logo.png" alt="Logo" width="100">
    </a>
  </div>
  <div class="container">
    <h3 class="text-center">Gestão de Encomendas</h3>
    <table class="table table-striped mt-4">
      <thead class="table-dark">
        <tr>
          <th>ID da Compra</th>
          <th>Nome do Cliente</th>
          <th>E-mail</th>
          <th>Data</th>
          <th>Valor Total (€)</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody id="order-list">
        <!-- Encomendas serão renderizadas aqui dinamicamente -->
      </tbody>
    </table>
  </div>
  <div style="position: fixed; bottom: 10px; right: 10px; z-index: 1000; opacity: 0.5;">
    <a href="admin.php" title="Voltar ao admin">
      <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; color: gray;"></i>
    </a>
  </div>
  <script>
    const ordersFile = './encomendas.json';
    let orders = [];

    async function loadOrders() {
      try {
        const response = await fetch(ordersFile);

        if (!response.ok) {
          throw new Error('Erro ao carregar as encomendas.');
        }

        const data = await response.json();

        if (!Array.isArray(data)) {
          throw new Error('O arquivo JSON não contém um array válido de encomendas.');
        }

        orders = data.map((order, index) => ({
          id: order.id || index + 1,
          nome: `${order.firstName || 'Sem Nome'} ${order.lastName || ''}`.trim(),
          email: order.email || 'Sem E-mail',
          data: new Date().toLocaleDateString('pt-PT'),
          total: parseFloat(order.total) || 0,
          itens: order.cartData || []
        }));

        renderOrders();
      } catch (error) {
        console.error('Erro ao carregar as encomendas:', error);
        alert('Não foi possível carregar as encomendas. Verifique o console para mais detalhes.');
      }
    }

    function renderOrders() {
      const orderList = document.getElementById('order-list');

      orderList.innerHTML = '';

      if (orders.length === 0) {
        const noOrdersMessage = document.createElement('tr');
        noOrdersMessage.innerHTML = `
        <td colspan="6" class="text-center">Nenhuma encomenda encontrada.</td>
      `;
        orderList.appendChild(noOrdersMessage);
        return;
      }

      orders.forEach(order => {
        const tr = document.createElement('tr');

        tr.innerHTML = `
        <td>${order.id || 'Sem ID'}</td>
        <td>${order.nome || 'Sem nome'}</td>
        <td>${order.email || 'Sem e-mail'}</td>
        <td>${order.data || 'Sem data'}</td>
        <td>€${order.total.toFixed(2)}</td>
        <td>
          <button class="btn btn-info btn-sm" onclick="viewOrder(${order.id})">Ver Itens</button>
          <button class="btn btn-success btn-sm" onclick="generateReceipt(${order.id})">Emitir Recibo</button>
          <button class="btn btn-danger btn-sm" onclick="removeOrder(${order.id})">Remover</button>
        </td>
      `;

        orderList.appendChild(tr);
      });
    }

    function viewOrder(orderId) {
      const order = orders.find(o => o.id === orderId);

      if (order) {
        let itemsDetails = `Itens da Encomenda ID ${order.id}:

`;
        if (Array.isArray(order.itens)) {
          order.itens.forEach(item => {
            itemsDetails += `- ${item.nome || 'Sem nome'} (${item.tamanho || 'Tamanho desconhecido'}) x${item.quantidade || 0}: €${(item.preco || 0).toFixed(2)}\n`;
          });
        } else {
          itemsDetails += 'Nenhum item disponível.\n';
        }
        alert(itemsDetails);
      } else {
        alert("Encomenda não encontrada!");
      }
    }

    async function generateReceipt(orderId) {
      const order = orders.find(o => o.id === orderId);

      if (!order) {
        alert("Encomenda não encontrada!");
        return;
      }

      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      doc.setFontSize(16);
      doc.text("Recibo da Encomenda", 20, 20);

      doc.setFontSize(12);
      doc.text(`ID da Compra: ${order.id}`, 20, 40);
      doc.text(`Nome do Cliente: ${order.nome}`, 20, 50);
      doc.text(`E-mail: ${order.email}`, 20, 60);
      doc.text(`Data: ${order.data}`, 20, 70);
      doc.text(`Valor Total: €${order.total.toFixed(2)}`, 20, 80);

      doc.text("Itens da Encomenda:", 20, 100);
      let yPos = 110;
      if (Array.isArray(order.itens) && order.itens.length > 0) {
        order.itens.forEach(item => {
          doc.text(
            `- ${item.nome || "Sem nome"} (${item.tamanho || "Sem tamanho"}) x${item.quantidade || 0} - €${(item.preco || 0).toFixed(2)}`,
            20,
            yPos
          );
          yPos += 10;
        });
      } else {
        doc.text("Nenhum item disponível.", 20, yPos);
      }

      doc.save(`recibo_encomenda_${order.id}.pdf`);
    }

    function removeOrder(orderId) {
      const orderIndex = orders.findIndex(o => o.id === orderId);
      if (orderIndex !== -1) {
        if (confirm("Tem certeza de que deseja remover esta encomenda?")) {
          orders.splice(orderIndex, 1);
          renderOrders();
        }
      } else {
        alert("Encomenda não encontrada!");
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      loadOrders();
    });
  </script>
</body>

</html>
