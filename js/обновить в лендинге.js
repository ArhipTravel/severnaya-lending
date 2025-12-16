// Замените функцию sendToTelegram на:
async function sendToTelegram(formData) {
    try {
        const response = await fetch('https://ваш-сайт.com/telegram-bot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });
        
        const result = await response.json();
        return result;
        
    } catch (error) {
        console.error('Ошибка отправки в Telegram:', error);
        return { 
            success: false, 
            error: 'Сетевая ошибка: ' + error.message 
        };
    }
}