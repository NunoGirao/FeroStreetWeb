<?php
// Caminho do arquivo JSON
$file = 'dados_afiliados.json';

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados enviados via POST
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Valida os campos obrigatórios
    if (!isset($data['instagram']) || !isset($data['tiktok'])) {
        http_response_code(400); // Código HTTP para "Bad Request"
        echo json_encode(['error' => 'Por favor, preencha todos os campos obrigatórios.']);
        exit;
    }

    // Gera o código de desconto
    $data['codigoDesconto'] = str_replace('@', '', $data['instagram']) . '10';

    // Lê os dados existentes no arquivo JSON (se existir)
    if (file_exists($file)) {
        $currentData = json_decode(file_get_contents($file), true);
    } else {
        $currentData = [];
    }

    // Adiciona o novo registro
    $data['idAfiliado'] = count($currentData) + 1;  // Atribui um ID único
    $data['status'] = 'pendente';  // Status inicial como "pendente"
    $currentData[] = $data;

    // Salva os dados atualizados no arquivo JSON
    if (file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'codigoDesconto' => $data['codigoDesconto']]);
    } else {
        http_response_code(500); // Código HTTP para "Internal Server Error"
        echo json_encode(['error' => 'Erro ao guardar os dados.']);
    }
} else {
    http_response_code(405); // Código HTTP para "Método Não Permitido"
    echo json_encode(['error' => 'Método não permitido.']);
}
?>
