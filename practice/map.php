<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Интерактивная карта</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        crossorigin=""></script>
    <style>
        body { margin: 0; padding: 0; }
        #map { width: 100%; height: 600px; } /* Задайте желаемую высоту карты */
    </style>
</head>
<body>
    <h1>Расположение кружка на карте</h1>
    <div id="map"></div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const address = urlParams.get('address');
        const mapDiv = document.getElementById('map');

        if (address) {
            // Используем Nominatim OpenStreetMap для геокодирования адреса
            const nominatimUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address)}&format=jsonv2`;

            fetch(nominatimUrl)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const latitude = parseFloat(data[0].lat);
                        const longitude = parseFloat(data[0].lon);

                        const map = L.map('map').setView([latitude, longitude], 15); // 15 - уровень масштабирования

                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);

                        L.marker([latitude, longitude]).addTo(map)
                            .bindPopup(`Местоположение: ${address}`)
                            .openPopup();
                    } else {
                        mapDiv.innerHTML = '<p>Не удалось найти координаты для указанного адреса.</p>';
                    }
                })
                .catch(error => {
                    console.error('Ошибка при геокодировании адреса:', error);
                    mapDiv.innerHTML = '<p>Произошла ошибка при загрузке карты.</p>';
                });
        } else {
            mapDiv.innerHTML = '<p>Адрес не указан.</p>';
        }
    </script>
</body>
</html>