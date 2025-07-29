<?php
// Endpoint para verificar status da transação PIX
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Verificar se o ID da transação foi fornecido
$transactionId = $_GET['id'] ?? null;

if (!$transactionId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID da transação não fornecido']);
    exit;
}

// Verificar se existe arquivo de status para esta transação
$statusFile = "status_{$transactionId}.json";

if (file_exists($statusFile)) {
    $statusData = json_decode(file_get_contents($statusFile), true);
    
    if ($statusData) {
        // Retornar status da transação
        echo json_encode([
            'status' => 'success',
            'data' => $statusData
        ]);
        
        // Se o pagamento foi confirmado, remover o arquivo para evitar consultas desnecessárias
        if ($statusData['status_transaction'] === 'PAID') {
            unlink($statusFile);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao ler dados da transação']);
    }
} else {
    // Arquivo não existe, transação ainda não foi processada
    echo json_encode([
        'status' => 'success',
        'data' => [
            'transaction_id' => $transactionId,
            'status_transaction' => 'WAITING_FOR_APPROVAL',
            'timestamp' => time()
        ]
    ]);
}
?> 