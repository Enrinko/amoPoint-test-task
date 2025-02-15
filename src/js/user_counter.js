async function getVisitorData() {
    // Получаем IP-адрес
    const ipResponse = await fetch('https://api.ipify.org?format=json');
    const ipData = await ipResponse.json();
    const ip = ipData.ip;

    // Получаем информацию о местоположении
    const locationResponse = await fetch(`https://ipapi.co/${ip}/json/`);
    const locationData = await locationResponse.json();
    const city = locationData.city;
    const device = navigator.userAgent;
    console.log({ ip, city, device });
    return { ip, city, device };
}

async function sendVisitorData() {
    const visitorData = await getVisitorData();
    await fetch( (window.location.protocol + '//' + window.location.host) + '/php/visits.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(visitorData),
    });
}

// Отправляем данные при загрузке страницы
window.onload = sendVisitorData;