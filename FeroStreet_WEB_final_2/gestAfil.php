<?php
// Caminho do arquivo JSON
$file = 'dados_afiliados.json';

// Lê os dados do arquivo JSON
if (file_exists($file)) {
    $afiliados = json_decode(file_get_contents($file), true);
} else {
    $afiliados = [];
}

// Filtra os afiliados pendentes
$pendentes = array_filter($afiliados, function($afiliado) {
    return isset($afiliado['status']) && $afiliado['status'] === 'pendente';
});

// Filtra os afiliados validados/ativos
$ativos = array_filter($afiliados, function($afiliado) {
    return isset($afiliado['status']) && $afiliado['status'] === 'ativo';
});

// Converte os afiliados pendentes e ativos em um formato JSON
$pendentesJson = json_encode(['pendentes' => array_values($pendentes)]);
$ativosJson = json_encode(['ativos' => array_values($ativos)]);
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Afiliados - Fero Street Wear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #222;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #222;
            color: #fff;
        }
        button {
            background-color: red;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            
        }
        button:hover {
            background-color: #444;
        }
        .back-button {
            background-color: #555;
        }
        .back-button:hover {
            background-color: #777;
        }
    </style>
</head>
<body>

<header>
    <h1>Gestão de Afiliados - Fero Street Wear</h1>
</header>

<div class="container">
    <h2>Afiliados Pendentes</h2>
    
    <!-- Tabela para exibir afiliados pendentes -->
    <table id="afiliadosPendentesTable">
        <thead>
            <tr>
                <th>Instagram</th>
                <th>TikTok</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <!-- Os dados serão preenchidos via JavaScript -->
        </tbody>
    </table>

    <h2>Afiliados Validados/Ativos</h2>
    
    <!-- Tabela para exibir afiliados ativos -->
    <table id="afiliadosAtivosTable">
        <thead>
            <tr>
                <th>Instagram</th>
                <th>TikTok</th>
                <th>Código de Desconto</th> <!-- Nova coluna para o código de desconto -->
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <!-- Os dados serão preenchidos via JavaScript -->
        </tbody>
    </table>

    
</div>

<script>
    // Carregar os dados de afiliados pendentes e validados a partir do PHP
    const afiliadosData = {
        pendentes: <?php echo $pendentesJson; ?>.pendentes,
        ativos: <?php echo $ativosJson; ?>.ativos
    };

    

    // Função para carregar os afiliados pendentes na tabela
    function carregarAfiliadosPendentes() {
        const tbodyPendentes = document.getElementById('afiliadosPendentesTable').getElementsByTagName('tbody')[0];
        tbodyPendentes.innerHTML = ''; // Limpar a tabela antes de adicionar os novos dados

        afiliadosData.pendentes.forEach(afiliado => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${afiliado.instagram}</td>
                <td>${afiliado.tiktok}</td>
                <td>
                    <button onclick="validarAfiliado(${afiliado.idAfiliado})">Validar</button>
                    <button onclick="recusarAfiliado(${afiliado.idAfiliado})">Recusar</button>
                </td>
            `;
            tbodyPendentes.appendChild(row);
        });
    }

    // Função para carregar os afiliados validados/ativos na tabela
    function carregarAfiliadosAtivos() {
        const tbodyAtivos = document.getElementById('afiliadosAtivosTable').getElementsByTagName('tbody')[0];
        tbodyAtivos.innerHTML = ''; // Limpar a tabela antes de adicionar os novos dados

        afiliadosData.ativos.forEach(afiliado => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${afiliado.instagram}</td>
                <td>${afiliado.tiktok}</td>
                <td>${afiliado.codigoDesconto || 'N/A'}</td> <!-- Exibe o código de desconto -->
                <td>
                    <button onclick="removerAfiliado(${afiliado.idAfiliado}, this.closest('tr'))">Remover</button>
                </td>
            `;
            tbodyAtivos.appendChild(row);
        });
    }

    // Função para validar o afiliado
    function validarAfiliado(idAfiliado) {
        fetch('validar_afiliado.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ idAfiliado: idAfiliado })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Afiliado ${idAfiliado} validado com sucesso!`);
                carregarAfiliadosPendentes(); // Atualiza a lista de pendentes
                carregarAfiliadosAtivos(); // Atualiza a lista de ativos
            } else {
                alert('Erro ao validar o afiliado.');
            }
        })
        .catch(error => console.error('Erro ao validar afiliado:', error));
    }

    // Função para recusar o afiliado
    function recusarAfiliado(idAfiliado) {
        if (confirm('Tem certeza que deseja recusar este afiliado?')) {
            fetch('recusar_afiliado.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ idAfiliado: idAfiliado })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Afiliado ${idAfiliado} recusado com sucesso!`);
                    carregarAfiliadosPendentes(); // Atualiza a lista de pendentes
                } else {
                    alert('Erro ao recusar o afiliado.');
                }
            })
            .catch(error => console.error('Erro ao recusar afiliado:', error));
        }
    }

    // Função para remover o afiliado da lista de ativos
    function removerAfiliado(idAfiliado, rowElement) {
        if (confirm('Tem certeza que deseja remover este afiliado da lista de ativos?')) {
            fetch('remover_afiliado.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ idAfiliado: idAfiliado })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Afiliado ${idAfiliado} removido com sucesso!`);
                    rowElement.remove(); // Remove a linha da tabela
                } else {
                    alert('Erro ao remover afiliado.');
                }
            })
            .catch(error => console.error('Erro ao remover afiliado:', error));
        }
    }

    // Carregar os afiliados pendentes e ativos quando a página for carregada
    window.onload = function() {
        carregarAfiliadosPendentes();
        carregarAfiliadosAtivos();
    };
</script>
<div style="position: fixed; bottom: 10px; right: 10px; z-index: 1000; opacity: 0.5;">
    <a href="admin.php" title="Voltar ao admin">
      <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; color: gray;"></i>
    </a>
  </div>
</body>
</html>
