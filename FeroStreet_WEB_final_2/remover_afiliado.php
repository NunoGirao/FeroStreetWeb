<?php
$file = 'dados_afiliados.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!isset($data['idAfiliado'])) {
        echo json_encode(['error' => 'ID do afiliado não fornecido']);
        exit;
    }

    $idAfiliado = $data['idAfiliado'];

    if (file_exists($file)) {
        $afiliados = json_decode(file_get_contents($file), true);
    } else {
        echo json_encode(['error' => 'Arquivo de afiliados não encontrado']);
        exit;
    }

    // Filtra o afiliado a ser removido
    $afiliados = array_filter($afiliados, function($afiliado) use ($idAfiliado) {
        return $afiliado['idAfiliado'] !== $idAfiliado;
    });

    // Reindexa o array
    $afiliados = array_values($afiliados);

    if (file_put_contents($file, json_encode($afiliados, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Erro ao salvar arquivo']);
    }
}
