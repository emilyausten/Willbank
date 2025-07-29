<?php
// Webhook para receber notificações de status do PIX da API SyncPay
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Log das notificações recebidas
$logFile = 'pix_webhook.log';

// Receber dados do webhook
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Log da requisição
$logEntry = date('Y-m-d H:i:s') . " - Webhook recebido: " . $input . "\n";
file_put_contents($logFile, $logEntry, FILE_APPEND);

// Verificar se os dados são válidos
if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
    exit;
}

// Extrair informações importantes
$transactionId = $data['idTransaction'] ?? null;
$status = $data['status_transaction'] ?? null;
$amount = $data['amount'] ?? null;
$customerName = $data['customer']['name'] ?? null;

// Log das informações extraídas
$logEntry = date('Y-m-d H:i:s') . " - Transaction ID: $transactionId, Status: $status, Amount: $amount, Customer: $customerName\n";
file_put_contents($logFile, $logEntry, FILE_APPEND);

// Processar diferentes status
switch ($status) {
    case 'PAID':
        // Pagamento confirmado
        $logEntry = date('Y-m-d H:i:s') . " - PAGAMENTO CONFIRMADO para Transaction ID: $transactionId\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
        
        // Salvar status no arquivo para ser lido pelo frontend
        $statusData = [
            'transaction_id' => $transactionId,
            'status_transaction' => $status,
            'amount' => $amount,
            'customer_name' => $customerName,
            'timestamp' => time()
        ];
        
        $statusFile = "status_{$transactionId}.json";
        file_put_contents($statusFile, json_encode($statusData));
        
        // Aqui você pode:
        // 1. Atualizar banco de dados
        // 2. Enviar e-mail de confirmação
        // 3. Liberar o empréstimo
        // 4. Enviar SMS de confirmação
        
        break;
        
    case 'EXPIRED':
        // PIX expirado
        $logEntry = date('Y-m-d H:i:s') . " - PIX EXPIRADO para Transaction ID: $transactionId\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
        
        // Salvar status de expirado
        $statusData = [
            'transaction_id' => $transactionId,
            'status_transaction' => $status,
            'timestamp' => time()
        ];
        
        $statusFile = "status_{$transactionId}.json";
        file_put_contents($statusFile, json_encode($statusData));
        
        break;
        
    case 'CANCELLED':
        // PIX cancelado
        $logEntry = date('Y-m-d H:i:s') . " - PIX CANCELADO para Transaction ID: $transactionId\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
        
        // Salvar status de cancelado
        $statusData = [
            'transaction_id' => $transactionId,
            'status_transaction' => $status,
            'timestamp' => time()
        ];
        
        $statusFile = "status_{$transactionId}.json";
        file_put_contents($statusFile, json_encode($statusData));
        
        break;
        
    default:
        // Status desconhecido
        $logEntry = date('Y-m-d H:i:s') . " - STATUS DESCONHECIDO: $status para Transaction ID: $transactionId\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
        
        break;
}

// Responder com sucesso
http_response_code(200);
echo json_encode([
    'status' => 'success',
    'message' => 'Webhook processado com sucesso',
    'transaction_id' => $transactionId,
    'status_received' => $status
]);

// Função para enviar e-mail de confirmação (exemplo)
function sendConfirmationEmail($customerName, $amount, $transactionId) {
    $to = "cliente@email.com"; // E-mail do cliente
    $subject = "Pagamento Confirmado - WillBank";
    $message = "
    Olá $customerName,
    
    Seu pagamento de R$ $amount foi confirmado com sucesso!
    
    Transaction ID: $transactionId
    
    Seu empréstimo será liberado em breve.
    
    Atenciosamente,
    Equipe WillBank
    ";
    
    $headers = "From: suporte@willbank.com";
    
    mail($to, $subject, $message, $headers);
}

// Função para enviar SMS (exemplo)
function sendConfirmationSMS($phone, $amount) {
    // Integração com serviço de SMS
    // Exemplo: Twilio, Zenvia, etc.
    
    $message = "WillBank: Seu pagamento de R$ $amount foi confirmado! Empréstimo será liberado em breve.";
    
    // Implementar envio de SMS aqui
    // file_put_contents('sms.log', date('Y-m-d H:i:s') . " - SMS enviado para $phone: $message\n", FILE_APPEND);
}
?> 