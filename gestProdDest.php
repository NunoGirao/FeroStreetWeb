<?php
// Carregar produtos do ficheiro JSON
$produtos = json_decode(file_get_contents('produtos.json'), true);

// Função para salvar os dados no arquivo JSON
function salvarProdutos($produtos) {
    file_put_contents('produtos.json', json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Função para adicionar ou remover destaque de um produto
if (isset($_POST['toggle_destaque'])) {
    foreach ($produtos as &$produto) {
        if ($produto['id'] == $_POST['produto_id']) {
            // Alterna o estado do destaque
            $produto['destaque'] = !$produto['destaque'];
            break;
        }
    }
    salvarProdutos($produtos);
    header("Location: gestProdDest.php");
    exit;
}

// Filtrar os produtos destacados (somente aqueles que têm 'destaque' == true)
$produtosDestacados = array_filter($produtos, fn($produto) => isset($produto['destaque']) && $produto['destaque'] === true);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Produtos em Destaque</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .highlighted {
            background-color: #fff3cd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-5">Gestão de Produtos em Destaque</h1>

        <!-- Tabela dos Produtos em Destaque -->
        <h3>Produtos em Destaque</h3>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-warning">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Tamanhos</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtosDestacados as $produto): ?>
                <tr class="highlighted">
                    <td><?php echo $produto['id']; ?></td>
                    <td><?php echo $produto['nome']; ?></td>
                    <td><?php echo $produto['preço']; ?> €</td>
                    <td><?php echo implode(", ", $produto['tamanho']); ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                            <button type="submit" name="toggle_destaque" class="btn btn-danger btn-sm">
                                Remover Destaque
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Tabela dos Outros Produtos -->
        <h3 class="mt-5">Outros Produtos</h3>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-secondary">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Tamanhos</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <?php if (!isset($produto['destaque']) || !$produto['destaque']): ?>
                    <tr>
                        <td><?php echo $produto['id']; ?></td>
                        <td><?php echo $produto['nome']; ?></td>
                        <td><?php echo $produto['preço']; ?> €</td>
                        <td><?php echo implode(", ", $produto['tamanho']); ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                                <button type="submit" name="toggle_destaque" class="btn btn-primary btn-sm">
                                    Adicionar Destaque
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div style="position: fixed; bottom: 10px; right: 10px; z-index: 1000; opacity: 0.5;">
        <a href="admin.php" title="Voltar ao admin">
            <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; color: gray;"></i>
        </a>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
