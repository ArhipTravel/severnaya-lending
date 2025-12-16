<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$BOT_TOKEN = '7874729556:AAHF0YHJbBveaswKlIq9WKFxIIXRT3muN0A';
$CHAT_ID = '475508709';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        echo json_encode(['success' => false, 'error' => 'No data received']);
        exit;
    }
    
    // Формируем сообщение для Telegram
    $message = "📋 Новая заявка на бронирование\n\n";
    $message .= "👤 Имя: " . htmlspecialchars($data['name']) . "\n";
    $message .= "📞 Телефон: " . htmlspecialchars($data['phone']) . "\n";
    if (!empty($data['email'])) {
        $message .= "📧 Email: " . htmlspecialchars($data['email']) . "\n";
    }
    $message .= "📅 Даты: " . htmlspecialchars($data['checkin']) . " - " . htmlspecialchars($data['checkout']) . "\n";
    $message .= "🏨 Номер: " . htmlspecialchars($data['room']) . "\n";
    $message .= "👥 Гостей: " . htmlspecialchars($data['guests']) . "\n";
    if (!empty($data['comment'])) {
        $message .= "💬 Комментарий:\n" . htmlspecialchars($data['comment']) . "\n";
    }
    $message .= "\n⏰ Время заявки: " . date('d.m.Y H:i:s');
    
    // Отправляем в Telegram
    $url = "https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage";
    $postData = [
        'chat_id' => $CHAT_ID,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $response = curl_exec($ch);
    curl_close($ch);
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>