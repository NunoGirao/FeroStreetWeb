<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Caminho para o arquivo JSON
    $file = 'encomendas.json';

    
    $jsonData = file_get_contents('php://input');
    $newOrder = json_decode($jsonData, true);

    if ($newOrder) {
        // Carregar as encomendas existentes
        if (file_exists($file)) {
            $currentData = json_decode(file_get_contents($file), true);
        } else {
            $currentData = [];
        }

        // Adicionar nova encomenda ao array
        $currentData[] = $newOrder;

        // Salvar de volta no arquivo JSON
        file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT));

        echo json_encode(['success' => true, 'message' => 'Encomenda salva com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos enviados.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
?>