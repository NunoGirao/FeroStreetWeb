<?php
// Carregar produtos do ficheiro JSON
$produtos = json_decode(file_get_contents('produtos.json'), true);

// Função para salvar os dados no arquivo JSON sem alterar a formatação
function salvarProdutos($produtos) {
    file_put_contents('produtos.json', json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Função para adicionar um novo produto
if (isset($_POST['add_produto'])) {
    $novoProduto = [
        "id" => count($produtos) > 0 ? max(array_column($produtos, 'id')) + 1 : 1, // Gera um ID novo automaticamente
        "nome" => $_POST['nome'],
        "preço" => $_POST['preco'],
        "descrição" => $_POST['descricao'],
        "foto" => $_POST['foto'],
        "tipo" => $_POST['tipo_selecionado'],
        "tamanho" => explode(',', $_POST['tamanho']),
        "destaque" => isset($_POST['destaque']) ? true : false
    ];
    $produtos[] = $novoProduto;
    salvarProdutos($produtos);
}

// Função para remover um produto
if (isset($_GET['remove_id'])) {
    $produtos = array_filter($produtos, function ($produto) {
        return $produto['id'] != $_GET['remove_id'];
    });
    salvarProdutos($produtos);
}

// Função para alterar o preço de um produto
if (isset($_POST['alterar_preco'])) {
    foreach ($produtos as &$produto) {
        if ($produto['id'] == $_POST['id']) {
            $produto['preço'] = $_POST['novo_preco'];
            break;
        }
    }
    salvarProdutos($produtos);
}

// Identificar tipos únicos
$tiposExistentes = array_unique(array_column($produtos, 'tipo'));

// Agrupar os produtos por tipo
$produtosPorTipo = [];
foreach ($produtos as $produto) {
    $produtosPorTipo[$produto['tipo']][] = $produto;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Stock</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Gestão de Stock</h1>
        
        <!-- Formulário para adicionar um novo produto -->
        <form method="POST" class="mb-5">
            <h3>Adicionar Produto</h3>
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="text" name="preco" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="foto">Foto (URL)</label>
                <input type="text" name="foto" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tipo_selecionado">Tipo</label>
                <select name="tipo_selecionado" class="form-control" required>
                    <?php foreach ($tiposExistentes as $tipo): ?>
                        <option value="<?php echo $tipo; ?>"><?php echo $tipo; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tamanho">Tamanhos (separados por vírgulas)</label>
                <input type="text" name="tamanho" class="form-control" required>
            </div>
            <div class="form-check">
                <input type="checkbox" name="destaque" class="form-check-input">
                <label for="destaque" class="form-check-label">Produto em Destaque</label>
            </div>
            <button type="submit" name="add_produto" class="btn btn-primary mt-3">Adicionar Produto</button>
        </form>

        <!-- Exibição dos produtos agrupados por tipo -->
        <h3>Produtos em Stock</h3>
        <?php foreach ($produtosPorTipo as $tipo => $produtosDoTipo): ?>
        <h4><?php echo $tipo; ?></h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Tamanhos</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtosDoTipo as $produto): ?>
                <tr>
                    <td><?php echo $produto['id']; ?></td>
                    <td><?php echo $produto['nome']; ?></td>
                    <td><?php echo $produto['preço']; ?></td>
                    <td><?php echo implode(", ", $produto['tamanho']); ?></td>
                    <td>
                        <a href="?remove_id=<?php echo $produto['id']; ?>" class="btn btn-danger btn-sm">Remover</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endforeach; ?>

        <!-- Formulário para alterar o preço -->
        <form method="POST" class="mt-5">
            <h3>Alterar Preço</h3>
            <div class="form-group">
                <label for="id">ID do Produto</label>
                <input type="number" name="id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="novo_preco">Novo Preço</label>
                <input type="text" name="novo_preco" class="form-control" required>
            </div>
            <button type="submit" name="alterar_preco" class="btn btn-primary mt-3">Alterar Preço</button>
        </form>
    </div>


    <div style="position: fixed; bottom: 10px; right: 10px; z-index: 1000; opacity: 0.5;">
    <a href="admin.php" title="Voltar ao Admin">
        <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; color: gray;"></i>
    </a>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

